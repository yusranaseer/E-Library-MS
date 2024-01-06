import 'dart:io';

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/components/NavBar.dart';
import 'package:elibrary_frontend/screens/pdf_view_page.dart';
import 'package:elibrary_frontend/widgets/dashboard_Buttons.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

class viewAnswers extends StatefulWidget {
  final int indexoftask;

  viewAnswers(this.indexoftask);

  @override
  State<StatefulWidget> createState() {
    return _viewAnswersState();
  }
}

class _viewAnswersState extends State<viewAnswers> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  Future<List<Map<String, dynamic>>> fetchData() async {
    final firestore = FirebaseFirestore.instance;
    final collection = firestore.collection('viewTask');
    final query = collection.where('taskId', isEqualTo: widget.indexoftask);

    try {
      final querySnapshot = await query.get();
      final List<Map<String, dynamic>> data = [];

      for (final doc in querySnapshot.docs) {
        final Map<String, dynamic> entry = {
          'id': doc.id,
          'studentId': doc['studentId'],
          'task': doc['task'],
          'submittedDate': doc['submittedDate'],
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
            child: whiteCurvedBox(
              Padding(
                padding: EdgeInsets.all(15.0),
                child: Column(
                  children: [
                    screenTopic('Task ID: ${widget.indexoftask}'),
                    SizedBox(
                      height: 5.0,
                    ),
                    FutureBuilder<List<Map<String, dynamic>>>(
                      future: fetchData(),
                      builder: (context, snapshot) {
                        if (snapshot.connectionState ==
                            ConnectionState.waiting) {
                          return CircularProgressIndicator();
                        } else if (snapshot.hasError) {
                          return Text('Error: ${snapshot.error}');
                        } else {
                          final data = snapshot.data;

                          return Flexible(
                            child: ListView(
                              children: [
                                GridView.builder(
                                  physics: NeverScrollableScrollPhysics(),
                                  shrinkWrap: true,
                                  gridDelegate:
                                      SliverGridDelegateWithFixedCrossAxisCount(
                                          crossAxisCount: 3),
                                  itemCount: data?.length,
                                  itemBuilder: (context, index) {
                                    return dashButtons(
                                      backgroundcolor: Color(0xffe5e5e5),
                                      iconcolor: Color(0xffcf1a26),
                                      text:
                                          'Student Id: ${data?[index]['studentId']}\n${data?[index]['submittedDate']}',
                                      size: 50.0,
                                      icon: Icons.download_for_offline_outlined,
                                      bordercolor: Colors.white,
                                      textcolor: Color(0xffd0cbc6),
                                      callback: () {
                                        downloadPDF(data?[index]['task'],
                                            'task_${widget.indexoftask}_student_${data?[index]['studentId']}');
                                      },
                                    );
                                  },
                                ),
                              ],
                            ),
                          );
                        }
                      },
                    )
                  ],
                ),
              ),
            ),
          )
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
}
