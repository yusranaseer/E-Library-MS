import 'dart:io';

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/loginorSignupCard.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/pdf_view_page.dart';
import 'package:elibrary_frontend/screens/taskViewStaffFirst.dart';
import 'package:elibrary_frontend/screens/viewAnswers.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:file_picker/file_picker.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_storage/firebase_storage.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:intl/intl.dart';
import 'package:open_file/open_file.dart';
import 'package:http/http.dart' as http;
import '../components/NavBar.dart';
import 'FilesPage1.dart';

class taskCRUDStaff extends StatefulWidget {
  final int index;

  taskCRUDStaff(this.index);

  @override
  State<StatefulWidget> createState() {
    return _taskCRUDStaffState();
  }
}

class _taskCRUDStaffState extends State<taskCRUDStaff> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  String taskName = '';
  String taskQue = '';

  @override
  void initState() {
    super.initState();
    fetchTaskData();
  }

  void fetchTaskData() async {
    try {
      await Firebase.initializeApp();

      QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
          .collection('task')
          .where('taskId', isEqualTo: widget.index)
          .limit(1)
          .get();

      if (taskSnapshot.docs.isNotEmpty) {
        setState(() {
          taskName = taskSnapshot.docs[0]['Task'];
          taskQue = taskSnapshot.docs[0]['question'];
        });
      } else {
        print('Task not found in Firestore.');
      }
    } catch (e) {
      print('Error fetching task data: $e');
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
            child: Column(
              children: [
                screenTopic(taskName),
                SizedBox(
                  height: 20.0,
                ),
                Row(
                  children: [
                    Icon(
                      Icons.description,
                      color: Color(0xffcf1a26),
                      size: 60.0,
                    ),
                    TextButton(
                        onPressed: () {
                          downloadPDF(taskQue, taskName);
                        },
                        child: Text(
                          taskName,
                          style: TextStyle(
                              fontWeight: FontWeight.w900,
                              fontSize: 25.0,
                              color: Color(0xff93897d)),
                        ))
                  ],
                ),
                SizedBox(
                  height: 20.0,
                ),
                Text(
                  'You can upload, edit and delete your tasks from here',
                  style: TextStyle(fontWeight: FontWeight.w900, fontSize: 30.0),
                ),
                SizedBox(
                  height: 20.0,
                ),
                // ListTile(
                //   horizontalTitleGap: 1.0,
                //   contentPadding: EdgeInsets.zero,
                //   onTap: () async {
                //     final result = await FilePicker.platform
                //         .pickFiles(allowMultiple: true);
                //     if (result == null) return;
                //
                //     // final file = result.files.first;
                //     // print('Name: ${file.name}');
                //     // openFile(file);
                //     openFiles(result.files);
                //   },
                //   leading: Icon(Icons.upload_file,
                //       color: Color(0xffcf1a26), size: 60.0),
                //   title: Text(
                //     'Upload Your Answer Here',
                //     style: TextStyle(
                //         fontSize: 25.0,
                //         fontWeight: FontWeight.w900,
                //         color: Color(0xff93897d)),
                //   ),
                // )
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Expanded(
                      child: TextButton(
                          onPressed: () async {
                            final result = await FilePicker.platform.pickFiles(
                              allowMultiple: true,
                            );
                            if (result == null) return;

                            handleFileUpload(result.files);
                          },
                          child: loginorSignupCard('Edit', 0)),
                    ),
                    Expanded(
                      child: TextButton(
                          onPressed: () async {
                            deleteTask();
                          },
                          child: loginorSignupCard('Delete', 0)),
                    )
                  ],
                ),
                TextButton(
                    onPressed: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => viewAnswers(widget.index)));
                    },
                    child: loginorSignupCard('View Answers', 25))
              ],
            ),
          )))
        ],
      )),
    );
  }

  void deleteTask() async {
    try {
      int taskId = widget.index;

      QuerySnapshot querySnapshot = await FirebaseFirestore.instance
          .collection('task')
          .where('taskId', isEqualTo: taskId)
          .get();

      DocumentReference docRef = querySnapshot.docs[0].reference;
      await docRef.delete();

      print('File deleted from Firestore.');
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => taskViewStaffFirst()),
      );
    } catch (e) {
      print('Error deleting file from Firestore: $e');
    }
  }

  void addFileToFirestore(String taskFilePath, String name) async {
    try {
      int taskId = widget.index;
      DateTime submittedDate = DateTime.now().add(Duration(days: 14));
      String formattedDate = DateFormat('yyyy-MM-dd').format(submittedDate);

      // Check if the string ends with ".pdf" and remove it if it does
      if (name.endsWith(".pdf")) {
        name = name.substring(0, name.length - 4);
      }

      QuerySnapshot querySnapshot = await FirebaseFirestore.instance
          .collection('task')
          .where('taskId', isEqualTo: taskId)
          .get();

      DocumentReference docRef = querySnapshot.docs[0].reference;
      await docRef.update({
        'Task': name,
        'question': taskFilePath,
        'dueDate': formattedDate,
      });

      print('File details updated to Firestore.');
    } catch (e) {
      print('Error updating file details to Firestore: $e');
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
    if (files.isNotEmpty) {
      PlatformFile file = files.first;
      String localAssetPath =
          await uploadFileToFirestore(file.path!, file.name);

      if (localAssetPath != "null") {
        addFileToFirestore(localAssetPath, file.name);
        print('File uploaded and details added to Firestore.');
      } else {
        print("Error: " + localAssetPath);
      }
    }
  }

  Future<void> downloadPDF(String url, String name) async {
    final pdfUrl = url; // Replace with your Firebase Storage URL
    final response = await http.get(Uri.parse(pdfUrl));

    if (response.statusCode == 200) {
      // Save the downloaded PDF to a local file
      final filePath =
          '/storage/emulated/0/Download/$name.pdf'; // Set the desired file path
      final file = File(filePath);
      await file.writeAsBytes(response.bodyBytes);

      // Now, you can open or view the downloaded PDF using a PDF viewer.
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => PDFViewPage(pdfUrl: filePath)),
      );
    } else {
      // Handle the error, e.g., file not found or unauthorized access.
    }
  }

  void openFile(PlatformFile file) {
    OpenFile.open(file.path!);
  }

  void openFiles(List<PlatformFile> files) {
    Navigator.of(context).push(MaterialPageRoute(
        builder: (context) => filesPage1(
              files: files,
              onOpenedFile: openFile,
              widgetnavigate: taskCRUDStaff(widget.index),
            )));
  }
}
