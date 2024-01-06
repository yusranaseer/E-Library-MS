import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/pdf_view_page.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:file_picker/file_picker.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:open_file/open_file.dart';
import 'package:firebase_storage/firebase_storage.dart';
import 'dart:io';
import 'package:path/path.dart' as path;
import '../components/NavBar.dart';
import 'FilesPage.dart';
import 'package:intl/intl.dart';
import 'package:http/http.dart' as http;

class taskDetails extends StatefulWidget {
  final int index;

  taskDetails(this.index);

  @override
  State<StatefulWidget> createState() {
    return _taskDetailsState();
  }
}

class _taskDetailsState extends State<taskDetails> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  String taskName = '';
  String taskDate = '';
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
          taskDate = taskSnapshot.docs[0]['dueDate'];
          taskQue = taskSnapshot.docs[0]['question'];
        });
      } else {
        print('Task not found in Firestore.');
      }
    } catch (e) {
      print('Error fetching task data: $e');
    }
  }

  void addFileToFirestore(String taskFilePath, int studentId) async {
    try {
      int taskId = widget.index;
      DateTime submittedDate = DateTime.now();
      String formattedDate = DateFormat('yyyy-MM-dd').format(submittedDate);

      DocumentReference docRef =
          FirebaseFirestore.instance.collection('viewTask').doc();

      await docRef.set({
        'task': taskFilePath,
        'taskId': taskId,
        'studentId': studentId,
        'marks': 0,
        'submittedDate': formattedDate,
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
    int taskId = widget.index;

    final QuerySnapshot snapshot = await FirebaseFirestore.instance
        .collection('viewTask')
        .where('studentId', isEqualTo: userId)
        .where('taskId', isEqualTo: taskId)
        .get();

    DateTime dueDate = DateTime.now().add(Duration(days: 1));
    String todayDate = DateFormat('yyyy-MM-dd').format(dueDate);

    final QuerySnapshot snapshot1 = await FirebaseFirestore.instance
        .collection('task')
        .where('taskId', isEqualTo: taskId)
        .get();

    final date = snapshot1.docs[0]['dueDate'];

    if (todayDate.compareTo(date) <= 0) {
      if (snapshot.size == 0) {
        if (files.isNotEmpty) {
          PlatformFile file = files.first;
          String localAssetPath =
              await uploadFileToFirestore(file.path!, file.name);

          if (localAssetPath != "null") {
            addFileToFirestore(localAssetPath, userId);
            print('File uploaded and details added to Firestore.');
          } else {
            print("Error: " + localAssetPath);
          }
        }
      } else {
        print('Already Uploaded');
      }
    } else {
      print('Deadline Expired');
    }
  }

  void openFile(PlatformFile file) {
    OpenFile.open(file.path!);
  }

  void openFiles(List<PlatformFile> files) {
    Navigator.of(context).push(MaterialPageRoute(
        builder: (context) => filesPage(files: files, onOpenedFile: openFile)));
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
              child: whiteCurvedBox(
                Padding(
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
                                color: Color(0xff93897d),
                              ),
                            ),
                          ),
                        ],
                      ),
                      SizedBox(
                        height: 20.0,
                      ),
                      Text(
                        'Answer all the questions and upload your answer to the below link as a PDF with in ' +
                            taskDate +
                            ' 11.59pm.',
                        style: TextStyle(
                            fontWeight: FontWeight.w900, fontSize: 30.0),
                      ),
                      SizedBox(
                        height: 20.0,
                      ),
                      ListTile(
                        horizontalTitleGap: 1.0,
                        contentPadding: EdgeInsets.zero,
                        onTap: () async {
                          final result = await FilePicker.platform.pickFiles(
                            allowMultiple: true,
                          );
                          if (result == null) return;

                          handleFileUpload(result.files);
                        },
                        leading: Icon(
                          Icons.upload_file,
                          color: Color(0xffcf1a26),
                          size: 60.0,
                        ),
                        title: Text(
                          'Upload Your Answer Here',
                          style: TextStyle(
                            fontSize: 25.0,
                            fontWeight: FontWeight.w900,
                            color: Color(0xff93897d),
                          ),
                        ),
                      )
                    ],
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
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
}
