import 'package:flutter/material.dart';

class navDrawerItem extends StatelessWidget {
  final IconData _icon;
  final String _title;
  final VoidCallback _callback;

  navDrawerItem(this._icon, this._title, this._callback);

  @override
  Widget build(BuildContext context) {
    return ListTile(
      leading: Icon(
        _icon,
        size: 40.0,
        color: Color(0xffcf1a26),
      ),
      title: Text(_title,
          style: TextStyle(fontWeight: FontWeight.w900, fontSize: 20.0)),
      onTap: _callback,
    );
  }
}
