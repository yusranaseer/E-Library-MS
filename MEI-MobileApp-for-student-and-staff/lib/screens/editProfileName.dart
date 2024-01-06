import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/loginorSignupCard.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/widgets/textFieldProfile.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:elibrary_frontend/screens/profileScreen.dart';
import '../components/NavBar.dart';

class editProfileName extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _editProfileNameState();
  }
}

class _editProfileNameState extends State<editProfileName> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  TextEditingController FirstnameController = TextEditingController();
  TextEditingController LastnameController = TextEditingController();

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
          String newFirstName = FirstnameController.text;
          String newLastName = LastnameController.text;

          await students.doc(docId).update({
            'First_Name': newFirstName,
            'Last_Name': newLastName,
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
          String newFirstName = FirstnameController.text;
          String newLastName = LastnameController.text;
          String name = "$newFirstName $newLastName";
          await students.doc(docId).update({
            'Name': name,
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
                    textFieldProfile('First Name', Icons.badge_outlined,
                        FirstnameController, () {}),
                    SizedBox(
                      height: 6.0,
                    ),
                    textFieldProfile('Last Name', Icons.badge_outlined,
                        LastnameController, () {}),
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
