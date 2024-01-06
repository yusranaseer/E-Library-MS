import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/taskDetails.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:flutter/material.dart';

import '../components/NavBar.dart';

class taskDisplay extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _taskDisplayState();
  }
}

class _taskDisplayState extends State<taskDisplay> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  Future<List<Map<String, dynamic>>> fetchData() async {
    final firestore = FirebaseFirestore.instance;
    final collection = firestore.collection('task');

    try {
      final querySnapshot = await collection.get();
      final List<Map<String, dynamic>> data = [];

      for (final doc in querySnapshot.docs) {
        final Map<String, dynamic> entry = {
          'id': doc.id,
          'Task': doc['Task'],
          'dueDate': doc['dueDate'],
          'grade': doc['grade'],
          'taskId': doc['taskId'],
        };
        data.add(entry);
      }

      return data;
    } catch (e) {
      print('Error fetching data: $e');
      return [];
    }
  }

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
              screenTopic('Your Tasks'),
              FutureBuilder<List<Map<String, dynamic>>>(
                future: fetchData(),
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return CircularProgressIndicator();
                  } else if (snapshot.hasError) {
                    return Text('Error: ${snapshot.error}');
                  } else {
                    final data = snapshot.data;

                    return Flexible(
                      child: ListView.builder(
                          itemCount: data?.length,
                          itemBuilder: (context, index) {
                            return Container(
                              margin: EdgeInsets.symmetric(
                                  horizontal: 5.0, vertical: 10.0),
                              decoration: BoxDecoration(
                                  color: Color(0xffd9d9d9),
                                  borderRadius: BorderRadius.circular(10.0)),
                              child: ListTile(
                                onTap: () {},
                                title: Text(data?[index]['Task'],
                                    style: TextStyle(
                                        fontWeight: FontWeight.w900,
                                        fontSize: 25.0,
                                        color: Color(0xff93897d))),
                                trailing: TextButton(
                                    style: ButtonStyle(
                                        padding: MaterialStatePropertyAll(
                                            EdgeInsets.zero),
                                        shape: MaterialStateProperty.all<
                                                RoundedRectangleBorder>(
                                            RoundedRectangleBorder(
                                                borderRadius:
                                                    BorderRadius.circular(10.0),
                                                side: BorderSide(
                                                    color: Color(0xffcf1a26)))),
                                        backgroundColor:
                                            MaterialStatePropertyAll(
                                                Color(0xffcf1a26))),
                                    onPressed: () {
                                      Navigator.push(
                                          context,
                                          MaterialPageRoute(
                                              builder: (context) => taskDetails(
                                                  data?[index]['taskId']
                                                      as int)));
                                    },
                                    child: Text(
                                      'Do',
                                      style: TextStyle(
                                          color: Colors.white,
                                          fontSize: 15.0,
                                          fontWeight: FontWeight.w900),
                                    )),
                              ),
                            );
                          }),
                    );
                  }
                },
              )
            ]),
          )))
        ],
      )),
    );
  }
}
