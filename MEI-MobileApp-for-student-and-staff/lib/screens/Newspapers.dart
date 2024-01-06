import 'package:flutter/material.dart';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:url_launcher/url_launcher.dart';
import '../components/NavBar.dart';
import '../components/headerwithNavbar.dart';
import '../components/whiteCurvedBox.dart';
import '../widgets/dashboard_Buttons.dart';
import '../widgets/screenTopic.dart';

class newspapers extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _newspapersState();
  }
}

class _newspapersState extends State<newspapers> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  Future<List<Map<String, dynamic>>> fetchData() async {
    final firestore = FirebaseFirestore.instance;
    final collection = firestore.collection('newspaper');

    try {
      final querySnapshot = await collection.get();
      final List<Map<String, dynamic>> data = [];

      for (final doc in querySnapshot.docs) {
        final Map<String, dynamic> entry = {
          'id': doc.id,
          'name': doc['name'],
          'paper': doc['paper'],
          'date': doc['date'],
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
                      screenTopic("News Papers"),
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
                                            '${data?[index]['name']}\n${data?[index]['date']}',
                                        size: 50.0,
                                        icon: Icons.import_contacts,
                                        bordercolor: Colors.white,
                                        textcolor: Color(0xffd0cbc6),
                                        callback: () {
                                          launchLink(data?[index]['paper'],
                                              isNewTab: true);
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

  Future<void> launchLink(String url, {bool isNewTab = true}) async {
    await launchUrl(
      Uri.parse(url),
      webOnlyWindowName: isNewTab ? '_blank' : '_self',
    );
  }
}
