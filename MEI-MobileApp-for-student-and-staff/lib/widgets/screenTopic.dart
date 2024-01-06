import 'package:flutter/material.dart';

class screenTopic extends StatelessWidget {
  final String _topic;

  screenTopic(this._topic);

  @override
  Widget build(BuildContext context) {
    return Center(
        child: Text(
      _topic,
      style: TextStyle(
          color: Color(0xffcf1a26),
          fontWeight: FontWeight.w900,
          fontSize: 35.0),
    ));
  }
}
