import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

import '../components/NavBar.dart';

class RewardDetails extends StatefulWidget {
  final int index;

  RewardDetails(this.index);

  @override
  State<StatefulWidget> createState() {
    return _rewardDetailsState();
  }
}

class _rewardDetailsState extends State<RewardDetails> {
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
              child: whiteCurvedBox(
            Padding(
              padding: EdgeInsets.all(15.0),
              child: Column(
                children: [screenTopic('Certificate ${widget.index}')],
              ),
            ),
          ))
        ],
      )),
    );
  }
}
