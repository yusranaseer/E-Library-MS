import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/screens/profileScreen.dart';
import 'package:elibrary_frontend/screens/taskViewStaffFirst.dart';
import 'package:elibrary_frontend/widgets/navDrawerItem.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:elibrary_frontend/screens/loginScreen.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import '../screens/About.dart';
import '../screens/Newspapers.dart';
import '../screens/RewardsScreen.dart';
import '../screens/booksScreen.dart';
import '../screens/innovationScreen.dart';
import '../screens/pastPapers.dart';
import '../screens/practicles.dart';
import '../screens/taskDisplay.dart';

class NavBar extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _NavBarState();
  }
}

class _NavBarState extends State<NavBar> {
  String name = '';
  String email = '';
  String img = '';
  dynamic type = '';

  @override
  void initState() {
    super.initState();
    fetchTaskData(); // Fetch the task data when the widget is initialized
  }

  // Function to fetch task data from Firestore based on taskId
  void fetchTaskData() async {
    dynamic id = await SessionManager().get("user");
    int userId = id;
    type = await SessionManager().get("usertype");
    if (type == 'student') {
      try {
        await Firebase
            .initializeApp(); // Initialize Firebase if not already done

        // Replace 'your_collection_name' with the actual name of your Firestore collection
        // Replace 'taskId' with the field name you're using to identify tasks
        QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
            .collection('student')
            .where('UID', isEqualTo: userId) // Query by taskId
            .limit(1) // Limit to one result (assuming taskId is unique)
            .get();

        if (taskSnapshot.docs.isNotEmpty) {
          // If a matching document is found
          setState(() {
            name = taskSnapshot.docs[0]['username'];
            email = taskSnapshot.docs[0]['Email'];
            img = taskSnapshot.docs[0]['img'];
          });
        } else {
          // Handle case where no matching document is found
          print('User not found in Firestore.');
        }
      } catch (e) {
        print('Error fetching user data: $e');
      }
    } else {
      try {
        await Firebase
            .initializeApp(); // Initialize Firebase if not already done

        // Replace 'your_collection_name' with the actual name of your Firestore collection
        // Replace 'taskId' with the field name you're using to identify tasks
        QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
            .collection('staff')
            .where('UId', isEqualTo: userId) // Query by taskId
            .limit(1) // Limit to one result (assuming taskId is unique)
            .get();

        if (taskSnapshot.docs.isNotEmpty) {
          // If a matching document is found
          setState(() {
            name = taskSnapshot.docs[0]['username'];
            email = taskSnapshot.docs[0]['Email'];
            img = taskSnapshot.docs[0]['img'];
          });
        } else {
          // Handle case where no matching document is found
          print('User not found in Firestore.');
        }
      } catch (e) {
        print('Error fetching user data: $e');
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: ListView(
        children: [
          UserAccountsDrawerHeader(
            accountName: Text(name,
                style: TextStyle(color: Color(0xffcf1a26), fontSize: 20.0)),
            accountEmail: Text(email,
                style: TextStyle(color: Color(0xffcf1a26), fontSize: 15.0)),
            currentAccountPicture: CircleAvatar(
              child: ClipOval(
                child: Image.network(
                  img,
                  width: 80,
                  height: 80,
                  fit: BoxFit.cover,
                ),
              ),
            ),
            decoration: BoxDecoration(color: Color(0xffd9d9d9)),
          ),
          navDrawerItem(Icons.library_books, 'Books', () {
            Navigator.push(context, MaterialPageRoute(builder: (context) {
              return booksScreen();
            }));
          }),
          navDrawerItem(Icons.task, 'Tasks', () {
            if (type == 'student') {
              Navigator.push(context, MaterialPageRoute(builder: (context) {
                return taskDisplay();
              }));
            } else if (type == 'staff') {
              Navigator.push(context, MaterialPageRoute(builder: (context) {
                return taskViewStaffFirst();
              }));
            }
          }),
          navDrawerItem(Icons.history_edu, 'Past Papers', () {
            Navigator.push(context, MaterialPageRoute(builder: (context) {
              return pastPapers();
            }));
          }),
          navDrawerItem(Icons.groups, 'About Us', () {
            Navigator.push(context, MaterialPageRoute(builder: (context) {
              return AboutUs();
            }));
          }),
          navDrawerItem(Icons.biotech, 'Practicals', () {
            Navigator.push(context, MaterialPageRoute(builder: (context) {
              return practiclesScreen();
            }));
          }),
          if (type == 'student')
            navDrawerItem(Icons.emoji_objects, 'Innovations', () {
              Navigator.push(context, MaterialPageRoute(builder: (context) {
                return innovationScreen();
              }));
            }),
          if (type == 'student')
            navDrawerItem(Icons.payments, 'Rewards', () {
              Navigator.push(context, MaterialPageRoute(builder: (context) {
                return RewardsScreen();
              }));
            }),
          navDrawerItem(Icons.newspaper, 'News Papers', () {
            Navigator.push(context, MaterialPageRoute(builder: (context) {
              return newspapers();
            }));
          }),
          Divider(height: 30.0),
          navDrawerItem(Icons.account_circle, 'Account', () {
            Navigator.push(context, MaterialPageRoute(builder: (context) {
              return profileScreen();
            }));
          }),
          navDrawerItem(Icons.logout, 'Logout', () async {
            await SessionManager().destroy();
            Navigator.push(context, MaterialPageRoute(builder: (context) {
              return loginScreen();
            }));
          }),
        ],
      ),
    );
  }
}
