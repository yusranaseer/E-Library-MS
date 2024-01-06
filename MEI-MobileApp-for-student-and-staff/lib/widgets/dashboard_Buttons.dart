import 'package:flutter/material.dart';

class dashButtons extends StatelessWidget {
  final Color backgroundcolor;
  final Color bordercolor;
  final Color iconcolor;
  final Color textcolor;
  final String text;
  final IconData icon;
  double size;
  final VoidCallback callback;

  dashButtons(
      {super.key,
      required this.backgroundcolor,
      required this.iconcolor,
      required this.text,
      required this.size,
      required this.icon,
      required this.bordercolor,
      required this.textcolor,
      required this.callback});

  @override
  Widget build(BuildContext context) {
    return Column(children: [
      TextButton(
        onPressed: callback,
        child: Container(
          decoration: BoxDecoration(
              boxShadow: [
                BoxShadow(
                  color: backgroundcolor,
                  blurRadius: 3,
                  offset: Offset(4, 5),
                )
              ],
              color: backgroundcolor,
              border: Border.all(
                color: bordercolor,
                width: 1.0,
              )),
          width: size,
          height: size,
          child: Center(
            child: Icon(
              icon,
              color: iconcolor,
            ),
          ),
        ),
      ),
      SizedBox(
        height: 10.0,
      ),
      Text(
        text,
        style: TextStyle(color: textcolor, fontWeight: FontWeight.w900),
      )
    ]);
  }
}
