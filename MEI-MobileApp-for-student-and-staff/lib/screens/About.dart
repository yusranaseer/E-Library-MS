import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:flutter/material.dart';

import '../components/NavBar.dart';

class AboutUs extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _aboutUsState();
  }
}

class _aboutUsState extends State<AboutUs> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

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
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        screenTopic("About Us"),
                        Column(
                          children: [
                            Row(
                              children: [
                                Icon(Icons.apartment,
                                    size: 50.0, color: Color(0xffcf1a26)),
                                Text(
                                  'Mercy Education Institute',
                                  style: TextStyle(
                                      fontSize: 25.0,
                                      fontWeight: FontWeight.bold),
                                ),
                              ],
                            ),
                            Row(
                              children: [
                                Icon(Icons.home,
                                    size: 50.0, color: Color(0xffcf1a26)),
                                Expanded(
                                  child: Text(
                                    'Mercy Education Institute,\nMadurankuliya,Puttalam',
                                    maxLines: 3,
                                    style: TextStyle(
                                        fontSize: 25.0,
                                        fontWeight: FontWeight.bold),
                                  ),
                                ),
                              ],
                            ),
                            Row(
                              children: [
                                Icon(Icons.mail,
                                    size: 50.0, color: Color(0xffcf1a26)),
                                Expanded(
                                  child: Text(
                                    'admin@mecunique.lk',
                                    maxLines: 3,
                                    style: TextStyle(
                                        fontSize: 25.0,
                                        fontWeight: FontWeight.bold),
                                  ),
                                ),
                              ],
                            ),
                            Row(
                              children: [
                                Icon(Icons.phone,
                                    size: 50.0, color: Color(0xffcf1a26)),
                                Expanded(
                                  child: Text(
                                    '+94 32 2268401\n+94 32 2268403',
                                    maxLines: 3,
                                    style: TextStyle(
                                        fontSize: 25.0,
                                        fontWeight: FontWeight.bold),
                                  ),
                                ),
                              ],
                            ),
                            Row(
                              children: [
                                Icon(Icons.link,
                                    size: 50.0, color: Color(0xffcf1a26)),
                                Expanded(
                                  child: Text(
                                    'admin@mecunique.lk',
                                    maxLines: 3,
                                    style: TextStyle(
                                        fontSize: 25.0,
                                        fontWeight: FontWeight.bold),
                                  ),
                                ),
                              ],
                            )
                          ],
                        )
                      ],
                    ))))
          ],
        )));
  }
}
