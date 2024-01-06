import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/loginorSignupCard.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/taskDisplay.dart';
import 'package:file_picker/file_picker.dart';
import 'package:flutter/material.dart';
import 'package:quickalert/quickalert.dart';

import '../components/NavBar.dart';

class filesPage extends StatefulWidget {
  final List<PlatformFile> files;
  final ValueChanged<PlatformFile> onOpenedFile;

  const filesPage({super.key, required this.files, required this.onOpenedFile});

  @override
  State<StatefulWidget> createState() {
    return _filesPageState();
  }
}

class _filesPageState extends State<filesPage> {
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
            child: SingleChildScrollView(
              child: Column(children: [
                GridView.builder(
                    physics: NeverScrollableScrollPhysics(),
                    shrinkWrap: true,
                    gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisCount: 2,
                        mainAxisSpacing: 8,
                        crossAxisSpacing: 8),
                    itemCount: widget.files.length,
                    itemBuilder: (context, index) {
                      final file = widget.files[index];
                      return buildFile(file);
                    }),
                TextButton(
                    onPressed: () {
                      QuickAlert.show(
                        context: context,
                        type: QuickAlertType.success,
                        onConfirmBtnTap: () {
                          Navigator.push(
                              context,
                              MaterialPageRoute(
                                  builder: (context) => taskDisplay()));
                        },
                      );
                    },
                    child: loginorSignupCard('Upload', 1.0))
              ]),
            ),
          )))
        ],
      )),
    );
  }

  Widget buildFile(PlatformFile file) {
    final kb = file.size / 1024;
    final mb = kb / 1024;
    final fileSize =
        mb >= 1 ? '${mb.toStringAsFixed(2)} MB' : '${kb.toStringAsFixed(2)} KB';
    final extension = file.extension ?? 'none';

    return InkWell(
      onTap: () => widget.onOpenedFile(file),
      child: Container(
        padding: EdgeInsets.all(8),
        child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          Expanded(
              child: Container(
            alignment: Alignment.center,
            width: double.infinity,
            decoration: BoxDecoration(
                color: Color(0xffd0cbc6),
                borderRadius: BorderRadius.circular(12)),
            child: Text('.$extension',
                style: TextStyle(
                    fontSize: 28,
                    fontWeight: FontWeight.bold,
                    color: Colors.white)),
          )),
          const SizedBox(
            height: 8,
          ),
          Text(
            file.name,
            style: TextStyle(fontSize: 18),
            overflow: TextOverflow.ellipsis,
          ),
          Text(
            fileSize,
            style: TextStyle(fontSize: 16),
          ),
        ]),
      ),
    );
  }
}
