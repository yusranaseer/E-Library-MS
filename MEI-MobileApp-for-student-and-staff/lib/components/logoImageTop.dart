import 'package:flutter/material.dart';

class LogoImageTop extends StatelessWidget {
  final Color colors;
  final double radiusset;

  LogoImageTop(this.colors, this.radiusset);

  @override
  Widget build(BuildContext context) {
    return CircleAvatar(
      radius: radiusset,
      backgroundImage: AssetImage('assests/images/MEC_PNG _new.png'),
      backgroundColor: colors,
    );
  }
}
