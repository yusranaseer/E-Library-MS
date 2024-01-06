import 'package:flutter/material.dart';

class loginorSignupCard extends StatelessWidget {
  var option;
  final double width;

  loginorSignupCard(this.option, this.width);

  @override
  Widget build(BuildContext context) {
    return Card(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(80.0)),
      color: Colors.red[800],
      margin: EdgeInsets.symmetric(vertical: 10.0, horizontal: width),
      child: Padding(
        padding: EdgeInsets.all(10.0),
        child: Center(
          child: Text(
            '$option',
            style: TextStyle(
              fontSize: 30.0,
              color: Colors.white,
            ),
          ),
        ),
      ),
    );
  }
}
