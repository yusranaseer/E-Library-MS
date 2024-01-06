import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:file_picker/file_picker.dart';
import 'package:flutter/material.dart';
import 'package:open_file/open_file.dart';

import '../components/NavBar.dart';
import 'FilesPage.dart';

class taskDetails extends StatefulWidget {
  final int index;

  taskDetails(this.index);

  @override
  State<StatefulWidget> createState() {
    return _taskDetailsState();
  }
}

class _taskDetailsState extends State<taskDetails> {
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
            child: Column(
              children: [
                screenTopic('Task ${widget.index}'),
                SizedBox(
                  height: 20.0,
                ),
                Row(
                  children: [
                    Icon(
                      Icons.description,
                      color: Color(0xffcf1a26),
                      size: 60.0,
                    ),
                    TextButton(
                        onPressed: () {},
                        child: Text(
                          'Task ${widget.index}',
                          style: TextStyle(
                              fontWeight: FontWeight.w900,
                              fontSize: 25.0,
                              color: Color(0xff93897d)),
                        ))
                  ],
                ),
                SizedBox(
                  height: 20.0,
                ),
                Text(
                  'Answer all the questions and upload yours answer to the below link as pdf ',
                  style: TextStyle(fontWeight: FontWeight.w900, fontSize: 30.0),
                ),
                SizedBox(
                  height: 20.0,
                ),
                ListTile(
                  horizontalTitleGap: 1.0,
                  contentPadding: EdgeInsets.zero,
                  onTap: () async {
                    final result = await FilePicker.platform
                        .pickFiles(allowMultiple: true);
                    if (result == null) return;

                    // final file = result.files.first;
                    // print('Name: ${file.name}');
                    // openFile(file);
                    openFiles(result.files);
                  },
                  leading: Icon(Icons.upload_file,
                      color: Color(0xffcf1a26), size: 60.0),
                  title: Text(
                    'Upload Your Answer Here',
                    style: TextStyle(
                        fontSize: 25.0,
                        fontWeight: FontWeight.w900,
                        color: Color(0xff93897d)),
                  ),
                )
              ],
            ),
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
