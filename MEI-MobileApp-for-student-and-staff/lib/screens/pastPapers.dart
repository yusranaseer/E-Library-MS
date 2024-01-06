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

class pastPapers extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _pastPaperState();
  }
}

class _pastPaperState extends State<pastPapers> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  Future<List<Map<String, dynamic>>> fetchData() async {
    final firestore = FirebaseFirestore.instance;
    final collection = firestore.collection('pastpaper');

    try {
      final querySnapshot = await collection.get();
      final List<Map<String, dynamic>> data = [];

      for (final doc in querySnapshot.docs) {
        final Map<String, dynamic> entry = {
          'id': doc.id,
          'name': doc['name'],
          'paper': doc['paper'],
          'grade': doc['grade'],
          'year': doc['year'],
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
                      screenTopic("Past Papers"),
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
                                            '${data?[index]['name']}\nGrade ${data?[index]['grade']}\nYear ${data?[index]['year']}',
                                        size: 50.0,
                                        icon: Icons.import_contacts,
                                        bordercolor: Colors.white,
                                        textcolor: Color(0xffd0cbc6),
                                        callback: () {
                                          downloadPDF(data?[index]['paper'],
                                              '${data?[index]['name']}${data?[index]['grade']}${data?[index]['year']}');
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
