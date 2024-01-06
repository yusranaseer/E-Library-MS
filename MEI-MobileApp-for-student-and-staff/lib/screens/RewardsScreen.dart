import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/pdfPage.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';

import '../components/NavBar.dart';

class RewardsScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _RewardScreenState();
  }
}

class _RewardScreenState extends State<RewardsScreen> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  int coins = 0;
  int maxlevel = 0;

  @override
  void initState() {
    super.initState();
    fetchData();
  }

  void fetchData() async {
    try {
      dynamic id = await SessionManager().get("user");
      int userId = id;
      await Firebase.initializeApp();

      QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
          .collection('student')
          .where('UID', isEqualTo: userId)
          .limit(1)
          .get();

      if (taskSnapshot.docs.isNotEmpty) {
        setState(() {
          coins = taskSnapshot.docs[0]['coins'];
        });
      } else {
        print('User not found in Firestore.');
      }
    } catch (e) {
      print('Error fetching Rewards data: $e');
    }

    if (coins > 999) {
      maxlevel = 10;
    } else if (coins > 899) {
      maxlevel = 9;
    } else if (coins > 799) {
      maxlevel = 8;
    } else if (coins > 699) {
      maxlevel = 7;
    } else if (coins > 599) {
      maxlevel = 6;
    } else if (coins > 499) {
      maxlevel = 5;
    } else if (coins > 399) {
      maxlevel = 4;
    } else if (coins > 299) {
      maxlevel = 3;
    } else if (coins > 199) {
      maxlevel = 2;
    } else if (coins > 99) {
      maxlevel = 1;
    } else {
      maxlevel = 0;
    }
  }

  @override
  Widget build(BuildContext context) {
    final List<Map> myRewards = List.generate(
        maxlevel, (index) => {"id": index, "name": "Product $index"}).toList();
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
              screenTopic('Rewards'),
              Flexible(
                child: ListView.builder(
                    itemCount: myRewards.length,
                    itemBuilder: (context, index) {
                      index = index + 1;
                      return Container(
                        margin: EdgeInsets.symmetric(
                            horizontal: 5.0, vertical: 10.0),
                        decoration: BoxDecoration(
                            color: Color(0xffd9d9d9),
                            borderRadius: BorderRadius.circular(10.0)),
                        child: ListTile(
                          horizontalTitleGap: 1.0,
                          contentPadding: EdgeInsets.zero,
                          onTap: () {
                            // Navigator.push(
                            //     context,
                            //     MaterialPageRoute(
                            //         builder: (context) =>
                            //             RewardDetails(index)));
                            Navigator.push(
                                context,
                                MaterialPageRoute(
                                    builder: (context) => pdfPage()));
                          },
                          leading: Icon(Icons.card_membership,
                              color: Color(0xffcf1a26), size: 40.0),
                          title: Text('Certificate for Level $index',
                              style: TextStyle(
                                  fontWeight: FontWeight.w900,
                                  fontSize: 25.0,
                                  color: Color(0xff93897d))),
                        ),
                      );
                    }),
              )
            ]),
          )))
        ],
      )),
    );
  }
}
