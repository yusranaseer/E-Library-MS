import 'package:flutter/material.dart';

class whiteCurvedBox extends StatelessWidget {
  final Widget child;

  whiteCurvedBox(this.child);

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.only(
              topLeft: Radius.circular(20.0), topRight: Radius.circular(20.0))),
      child: child,
    );
  }
}
