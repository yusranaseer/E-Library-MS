import 'dart:io';

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/pdf_view_page.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:expansion_tile_card/expansion_tile_card.dart';
import 'package:file_picker/file_picker.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_storage/firebase_storage.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:intl/intl.dart';
import 'package:open_file/open_file.dart';
import 'package:http/http.dart' as http;
import '../components/NavBar.dart';
import '../widgets/dashboard_Buttons.dart';
import 'FilesPage.dart';

class innovationScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _innovationScreen();
  }
}

class _innovationScreen extends State<innovationScreen> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  final GlobalKey<ExpansionTileCardState> cardA = new GlobalKey();
  final GlobalKey<ExpansionTileCardState> cardB = new GlobalKey();
  List<Map<String, dynamic>> myProducts = []; // Initialize an empty list

  @override
  void initState() {
    super.initState();
    // Initialize Firebase
    Firebase.initializeApp().then((_) {
      fetchDataFromFirestore();
    });
  }

  // Function to fetch data from Firestore
  void fetchDataFromFirestore() async {
    dynamic id = await SessionManager().get("user");
    int userId = id;
    final firestore = FirebaseFirestore.instance;
    try {
      QuerySnapshot querySnapshot = await firestore
          .collection('innovation')
          .where('StudentId', isEqualTo: userId)
          .get();
      setState(() {
        myProducts = querySnapshot.docs
            .map((DocumentSnapshot document) =>
                document.data() as Map<String, dynamic>)
            .toList();
      });
    } catch (e) {
      print('Error fetching data from Firestore: $e');
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
            child: SingleChildScrollView(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Column(
                    children: [
                      ExpansionTileCard(
                        baseColor: Color(0xffd9d9d9),
                        expandedColor: Color(0xffd9d9d9),
                        key: cardA,
                        title: screenTopic('My Innovations'),
                        children: [
                          GridView.builder(
                            physics: NeverScrollableScrollPhysics(),
                            shrinkWrap: true,
                            gridDelegate:
                                SliverGridDelegateWithFixedCrossAxisCount(
                                    crossAxisCount: 3),
                            itemCount: myProducts.length,
                            itemBuilder: (context, index) {
                              int color = 0;
                              if (myProducts[index]['status'] == 'accepted') {
                                color = 0xff19fd07;
                              } else if (myProducts[index]['status'] ==
                                  'pending') {
                                color = 0xffffa700;
                              } else {
                                color = 0xffcf1a26;
                              }
                              return dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(color),
                                text: myProducts[index]['Innovation'],
                                size: 50.0,
                                icon: Icons.import_contacts,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  downloadPDF(myProducts[index]['product'],
                                      myProducts[index]['Innovation']);
                                },
                              );
                            },
                          ),
                        ],
                      ),
                    ],
                  ),
                  Divider(
                      height: 40.0, color: Color(0xffd9d9d9), thickness: 5.0),
                  ElevatedButton.icon(
                    style: ElevatedButton.styleFrom(
                        backgroundColor: Color(0xffd9d9d9),
                        minimumSize: Size.fromHeight(65.0)),
                    onPressed: () async {
                      final result = await FilePicker.platform
                          .pickFiles(allowMultiple: true);
                      if (result == null) return;

                      handleFileUpload(result.files);
                    },
                    icon: Icon(
                      color: Color(0xffcf1a26),
                      // <-- Icon
                      Icons.upload_file,
                      size: 40.0,
                    ),
                    label: Align(
                      alignment: Alignment.center,
                      child: Text('Upload Your Innovation Here',
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            color: Color(0xffcf1a26),
                            fontSize: 25.0,
                            fontWeight: FontWeight.w900,
                          )),
                    ), // <-- Text
                  ),
                ],
              ),
            ),
          )))
        ],
      )),
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

  Future<int> innoid() async {
    try {
      await Firebase.initializeApp();

      QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
          .collection('innovation')
          .orderBy('innoId', descending: true)
          .get();
      int innoid = 1;
      if (taskSnapshot.docs.isNotEmpty) {
        setState(() {
          innoid = taskSnapshot.docs[0]['innoId'] + 1;
        });
        return innoid;
      } else {
        print('First Innovation');
        return 1;
      }
    } catch (e) {
      print('Error fetching innovation data: $e');
      return 0;
    }
  }

  void addFileToFirestore(
      String taskFilePath, int studentId, String name) async {
    try {
      int innoId = await innoid();
      DateTime submittedDate = DateTime.now();
      String formattedDate = DateFormat('yyyy-MM-dd').format(submittedDate);

      // Check if the string ends with ".pdf" and remove it if it does
      if (name.endsWith(".pdf")) {
        name = name.substring(0, name.length - 4);
      }

      DocumentReference docRef =
          FirebaseFirestore.instance.collection('innovation').doc();

      await docRef.set({
        'Innovation': name,
        'innoId': innoId,
        'StudentId': studentId,
        'status': 'pending',
        'submitDate': formattedDate,
        'product': taskFilePath,
      });

      print('File details added to Firestore.');
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => innovationScreen()),
      );
    } catch (e) {
      print('Error adding file details to Firestore: $e');
    }
  }

  Future<String> uploadFileToFirestore(String filePath, String fileName) async {
    try {
      final Reference storageReference =
          FirebaseStorage.instance.ref('innovations/$fileName');
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

  void openFile(PlatformFile file) {
    OpenFile.open(file.path!);
  }

  void openFiles(List<PlatformFile> files) {
    Navigator.of(context).push(MaterialPageRoute(
        builder: (context) => filesPage(files: files, onOpenedFile: openFile)));
  }
}
