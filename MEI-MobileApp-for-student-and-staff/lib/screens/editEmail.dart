import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/loginorSignupCard.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/widgets/textFieldProfile.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:elibrary_frontend/screens/profileScreen.dart';
import '../components/NavBar.dart';

class editEmail extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _editEmailState();
  }
}

class _editEmailState extends State<editEmail> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  TextEditingController emailController = TextEditingController();

  Future<void> _update() async {
    // Get the user's ID from your session or wherever it's stored.
    dynamic userId =
        await SessionManager().get("user"); // Assuming you retrieve an int
    //String userId = userIdInt.toString(); // Convert it to a string
    print(userId);
    dynamic type = await SessionManager().get("usertype");

    // Check if userId is not null before proceeding.
    if (userId != null) {
      if (type == 'student') {
        // Reference to the Firestore collection.
        CollectionReference students =
            FirebaseFirestore.instance.collection('student');

        // Query the Firestore collection using the user-specific field (e.g., 'user_id').
        QuerySnapshot querySnapshot =
            await students.where('UID', isEqualTo: userId).get();

        // Check if any documents match the query (assuming there should be only one).
        if (querySnapshot.docs.isNotEmpty) {
          // Update the first matching document with the new data.
          var docId = querySnapshot.docs[0].id;
          String email = emailController.text;

          // check for existing email
          QuerySnapshot checkStudents =
              await students.where('Email', isEqualTo: email).get();

          CollectionReference staff =
              FirebaseFirestore.instance.collection('staff');
          // check for existing email
          QuerySnapshot checkStaff =
              await staff.where('Email', isEqualTo: email).get();

          if (checkStudents.docs.isNotEmpty) {
            print("Email Already Exist");
          } else if (checkStaff.docs.isNotEmpty) {
            print("Email Already Exist");
          } else {
            await students.doc(docId).update({
              'Email': email,
            }).then((_) {
              // Successfully updated data.
              print('User data updated successfully');
              Navigator.of(context).pushReplacement(MaterialPageRoute(
                builder: (context) => profileScreen(),
              ));
            }).catchError((error) {
              // Handle errors, e.g., network issues.
              print('Error updating user data: $error');
            });
          }
        }
      } else {
        // Reference to the Firestore collection.
        CollectionReference students =
            FirebaseFirestore.instance.collection('staff');

        // Query the Firestore collection using the user-specific field (e.g., 'user_id').
        QuerySnapshot querySnapshot =
            await students.where('UId', isEqualTo: userId).get();

        // Check if any documents match the query (assuming there should be only one).
        if (querySnapshot.docs.isNotEmpty) {
          // Update the first matching document with the new data.
          var docId = querySnapshot.docs[0].id;
          String email = emailController.text;

          // check for existing email
          QuerySnapshot checkStudents =
              await students.where('Email', isEqualTo: email).get();

          CollectionReference staff =
              FirebaseFirestore.instance.collection('student');
          // check for existing email
          QuerySnapshot checkStaff =
              await staff.where('Email', isEqualTo: email).get();

          if (checkStudents.docs.isNotEmpty) {
            print("Email Already Exist");
          } else if (checkStaff.docs.isNotEmpty) {
            print("Email Already Exist");
          } else {
            await students.doc(docId).update({
              'Email': email,
            }).then((_) {
              // Successfully updated data.
              print('User data updated successfully');
              Navigator.of(context).pushReplacement(MaterialPageRoute(
                builder: (context) => profileScreen(),
              ));
            }).catchError((error) {
              // Handle errors, e.g., network issues.
              print('Error updating user data: $error');
            });
          }
        }
      }
    }
  }

  //db end
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
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  children: [
                    textFieldProfile(
                        'Email', Icons.badge_outlined, emailController, () {}),
                    SizedBox(
                      height: 6.0,
                    ),
                  ],
                ),
                TextButton(
                  onPressed: _update,
                  child: loginorSignupCard('Update', 0.0),
                )
              ],
            ),
          )))
        ],
      )),
    );
  }
}
