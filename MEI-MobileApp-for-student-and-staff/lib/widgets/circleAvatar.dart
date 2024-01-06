import 'package:flutter/material.dart';

class circleAvatar extends StatelessWidget {
  final double radiusset;
  final String imageURL;

  circleAvatar(this.radiusset, this.imageURL);

  @override
  Widget build(BuildContext context) {
    return CircleAvatar(
      radius: radiusset,
      backgroundImage: AssetImage(imageURL),
    );
  }
}
