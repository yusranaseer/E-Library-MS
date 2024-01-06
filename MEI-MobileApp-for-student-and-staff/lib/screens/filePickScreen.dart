import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/loginorSignupCard.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/FilesPage.dart';
import 'package:file_picker/file_picker.dart';
import 'package:flutter/material.dart';
import 'package:open_file/open_file.dart';

import '../components/NavBar.dart';

class filePickScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _filePickScreenState();
  }
}

class _filePickScreenState extends State<filePickScreen> {
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
                  child: whiteCurvedBox(Padding(
                    padding: EdgeInsets.all(15.0),
                    child: Column(children: [
                      Container(),
                      TextButton(
                          onPressed: () async {
                            final result = await FilePicker.platform
                                .pickFiles(allowMultiple: true);
                            if (result == null) return;

                            // final file = result.files.first;
                            // print('Name: ${file.name}');
                            // openFile(file);
                            openFiles(result.files);
                          },
                          child: loginorSignupCard(
                              'Select Files to Upload', 1.0))
                    ]),
                  )))
            ],
          )),
    );
  }

  void openFile(PlatformFile file) {
    OpenFile.open(file.path!);
  }


  void openFiles(List<PlatformFile> files) {
    Navigator.of(context).push(MaterialPageRoute(
        builder: (context) => filesPage(files: files, onOpenedFile: openFile)));
  }
}
