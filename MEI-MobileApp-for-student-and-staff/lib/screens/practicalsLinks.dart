import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

import '../components/NavBar.dart';

class practiclesLinks extends StatefulWidget {
  final String link;
  final String practiclename;

  practiclesLinks(this.link, this.practiclename);
  @override
  State<StatefulWidget> createState() {
    return _practiclesLinksState();
  }
}

class _practiclesLinksState extends State<practiclesLinks> {
  Future<void> launchLink(String url, {bool isNewTab = true}) async {
    await launchUrl(
      Uri.parse(url),
      webOnlyWindowName: isNewTab ? '_blank' : '_self',
    );
  }

  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  final List<Map> mypracticals =
      List.generate(1, (index) => {"id": index, "name": "Product $index"})
          .toList();

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
            child: ListView.builder(
              itemCount: mypracticals.length,
              itemBuilder: (context, index) {
                return ListTile(
                  title: Text(widget.practiclename,
                      style: TextStyle(color: Color(0xffd9d9d9))),
                  leading: Icon(Icons.link),
                  onTap: () {
                    launchLink(widget.link, isNewTab: true);
                  },
                );
              },
            ),
          )))
        ],
      )),
    );
  }
}
