import 'dart:io';

import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/loginorSignupCard.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/taskCRUDStaff.dart';
import 'package:elibrary_frontend/screens/taskDetails.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:file_picker/file_picker.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_storage/firebase_storage.dart';
import 'package:flutter/material.dart';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:intl/intl.dart';
import '../components/NavBar.dart';

class taskViewStaffFirst extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _taskViewStaffFirstState();
  }
}

class _taskViewStaffFirstState extends State<taskViewStaffFirst> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  Future<List<Map<String, dynamic>>> fetchData() async {
    dynamic sid = await SessionManager().get("user");

    final firestore = FirebaseFirestore.instance;
    final collection = firestore.collection('task');
    final query = collection.where('staffId', isEqualTo: sid);

    try {
      final querySnapshot = await query.get();
      final List<Map<String, dynamic>> data = [];

      for (final doc in querySnapshot.docs) {
        final Map<String, dynamic> entry = {
          'id': doc.id,
          'Task': doc['Task'],
          'dueDate': doc['dueDate'],
          'grade': doc['grade'],
          'taskId': doc['taskId'],
        };
        data.add(entry);
      }

      return data;
    } catch (e) {
      print('Error fetching data: $e');
      return [];
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scaffoldkey,
      endDrawer: SafeArea(child: NavBar()),
      backgroundColor: Color(0xffd9d9d9),
      body: SafeArea(
          child: Column(
        children: [
          headerWithNavbar(_scaffoldkey),
          Expanded(
              child: whiteCurvedBox(Padding(
            padding: EdgeInsets.all(15.0),
            child: Column(children: [
              screenTopic('Tasks'),
              FutureBuilder<List<Map<String, dynamic>>>(
                future: fetchData(),
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return CircularProgressIndicator();
                  } else if (snapshot.hasError) {
                    return Text('Error: ${snapshot.error}');
                  } else {
                    final data = snapshot.data;

                    return Flexible(
                      child: ListView.builder(
                          itemCount: data?.length,
                          itemBuilder: (context, index) {
                            return Container(
                              margin: EdgeInsets.symmetric(
                                  horizontal: 5.0, vertical: 10.0),
                              decoration: BoxDecoration(
                                  color: Color(0xffd9d9d9),
                                  borderRadius: BorderRadius.circular(10.0)),
                              child: ListTile(
                                onTap: () {},
                                title: Text(data?[index]['Task'],
                                    style: TextStyle(
                                        fontWeight: FontWeight.w900,
                                        fontSize: 25.0,
                                        color: Color(0xff93897d))),
                                trailing: TextButton(
                                    style: ButtonStyle(
                                        padding: MaterialStatePropertyAll(
                                            EdgeInsets.zero),
                                        shape: MaterialStateProperty.all<
                                                RoundedRectangleBorder>(
                                            RoundedRectangleBorder(
                                                borderRadius:
                                                    BorderRadius.circular(10.0),
                                                side: BorderSide(
                                                    color: Color(0xffcf1a26)))),
                                        backgroundColor:
                                            MaterialStatePropertyAll(
                                                Color(0xffcf1a26))),
                                    onPressed: () {
                                      Navigator.push(
                                          context,
                                          MaterialPageRoute(
                                              builder: (context) =>
                                                  taskCRUDStaff(data?[index]
                                                      ['taskId'] as int)));
                                    },
                                    child: Text(
                                      'View',
                                      style: TextStyle(
                                          color: Colors.white,
                                          fontSize: 15.0,
                                          fontWeight: FontWeight.w900),
                                    )),
                              ),
                            );
                          }),
                    );
                  }
                },
              ),
              TextButton(
                  onPressed: () async {
                    final result = await FilePicker.platform.pickFiles(
                      allowMultiple: true,
                    );
                    if (result == null) return;

                    handleFileUpload(result.files);
                  },
                  child: loginorSignupCard('Upload New Task', 25.0))
            ]),
          )))
        ],
      )),
    );
  }

  Future<int> taskid() async {
    try {
      await Firebase.initializeApp();

      QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
          .collection('task')
          .orderBy('taskId', descending: true)
          .get();
      int taskid = 1;
      if (taskSnapshot.docs.isNotEmpty) {
        setState(() {
          taskid = taskSnapshot.docs[0]['taskId'] + 1;
        });
        return taskid;
      } else {
        print('First task');
        return 1;
      }
    } catch (e) {
      print('Error fetching task data: $e');
      return 0;
    }
  }

  void addFileToFirestore(String taskFilePath, int staffId, String name) async {
    try {
      int taskId = await taskid();
      DateTime dueDate = DateTime.now().add(Duration(days: 14));
      String formattedDate = DateFormat('yyyy-MM-dd').format(dueDate);

      // Check if the string ends with ".pdf" and remove it if it does
      if (name.endsWith(".pdf")) {
        name = name.substring(0, name.length - 4);
      }

      DocumentReference docRef =
          FirebaseFirestore.instance.collection('task').doc();

      await docRef.set({
        'Task': name,
        'taskId': taskId,
        'staffId': staffId,
        'grade': 'open for all',
        'dueDate': formattedDate,
        'question': taskFilePath,
      });

      print('File details added to Firestore.');
    } catch (e) {
      print('Error adding file details to Firestore: $e');
    }
  }

  Future<String> uploadFileToFirestore(String filePath, String fileName) async {
    try {
      final Reference storageReference =
          FirebaseStorage.instance.ref('task/$fileName');
      final File file = File(filePath);

      UploadTask uploadTask = storageReference.putFile(file);
      await uploadTask;

      String downloadURL = await storageReference.getDownloadURL();

      return downloadURL;
    } catch (e) {
      print('Error uploading file to Firestore: $e');
      return "null";
    }
  }

  void handleFileUpload(List<PlatformFile> files) async {
    dynamic id = await SessionManager().get("user");
    int userId = id;

    if (files.isNotEmpty) {
      PlatformFile file = files.first;
      String localAssetPath =
          await uploadFileToFirestore(file.path!, file.name);

      if (localAssetPath != "null") {
        addFileToFirestore(localAssetPath, userId, file.name);
        print('File uploaded and details added to Firestore.');
      } else {
        print("Error: " + localAssetPath);
      }
    }
  }
}
