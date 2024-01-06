import 'package:flutter/material.dart';

import 'logoImageTop.dart';

class headerWithNavbar extends StatefulWidget {
  final GlobalKey<ScaffoldState> _scaffoldkey;

  headerWithNavbar(this._scaffoldkey);

  @override
  State<StatefulWidget> createState() {
    return _headerWithNavbarState(_scaffoldkey);
  }
}

class _headerWithNavbarState extends State<headerWithNavbar> {
  final GlobalKey<ScaffoldState> _scaffoldkey;

  _headerWithNavbarState(this._scaffoldkey);

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        LogoImageTop(Colors.transparent, 60.0),
        IconButton(
            iconSize: 50.0,
            onPressed: () {
              return _scaffoldkey.currentState?.openEndDrawer();
            },
            icon: Icon(
              Icons.menu,
              color: Color(0xffcf1a26),
            ))
      ],
    );
  }
}
