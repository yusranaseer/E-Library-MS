import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/loginorSignupCard.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/widgets/textFieldProfile.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:elibrary_frontend/screens/profileScreen.dart';
import '../components/NavBar.dart';
import 'package:http/http.dart' as http;

class editPassword extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _editPasswordState();
  }
}

class _editPasswordState extends State<editPassword> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  TextEditingController CurrentPwd = TextEditingController();
  TextEditingController NewPwd = TextEditingController();
  TextEditingController RePwd = TextEditingController();

  Future<void> _update() async {
    // Get the user's ID from your session or wherever it's stored.
    dynamic userId =
        await SessionManager().get("user"); // Assuming you retrieve an int
    //String userId = userIdInt.toString(); // Convert it to a string
    print(userId);
    // Check if userId is not null before proceeding.
    if (userId != null) {
      // Reference to the Firestore collection.
      CollectionReference students =
          FirebaseFirestore.instance.collection('User');

      // Query the Firestore collection using the user-specific field (e.g., 'user_id').
      QuerySnapshot querySnapshot =
          await students.where('userID', isEqualTo: userId).get();

      // Check if any documents match the query (assuming there should be only one).
      var docId = querySnapshot.docs[0].id;

      String cpwd = CurrentPwd.text;
      String pwd = NewPwd.text;
      String rpwd = RePwd.text;

      int confirmPwd = await verifyPassword(userId, cpwd);

      if (confirmPwd == 1) {
        if (pwd == rpwd) {
          String encryptedPwd = await sendPassword(pwd);
          print(encryptedPwd);
          if (encryptedPwd == "null") {
            print("Error Converting Password: Password Hash Error");
          } else {
            await students.doc(docId).update({
              'password': encryptedPwd,
            }).then((_) {
              // Successfully updated data.
              print('User password updated successfully');
              Navigator.of(context).pushReplacement(MaterialPageRoute(
                builder: (context) => profileScreen(),
              ));
            }).catchError((error) {
              // Handle errors, e.g., network issues.
              print('Error updating password: $error');
            });
          }
        } else {
          print('Error updating password: New Passwords not matched');
        }
      } else {
        print('Error updating password: Invalid current password');
      }
    }
  }

  Future<String> sendPassword(String password) async {
    final Uri uri = Uri.parse(
        'http://192.168.36.2/project2/new_oop/updateClientPwd.php?password=$password');

    final response = await http.get(uri);
    if (response.statusCode == 200) {
      String encryptedPassword = response.body;
      print('Encrypted Password: $encryptedPassword');
      return encryptedPassword;
    } else {
      return "null";
    }
  }

  Future<int> verifyPassword(int userid, String password) async {
    String user = userid.toString();
    final response = await http.get(Uri.parse(
            'http://192.168.36.2/project2/new_oop/checkClientPwd.php?user=$user&pwd=$password') // Replace with your PHP script URL
        );
    print('id: $user and password: $password');
    if (response.statusCode == 200) {
      String responseBody = response.body;
      int intValue = int.parse(responseBody);
      if (intValue == 1) {
        // Password is correct
        return 1;
      } else {
        // Password is incorrect

        //print(intValue);
        return 0;
      }
    } else {
      // Handle the HTTP request error
      return -1;
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
                    textFieldProfile('Current Password', Icons.badge_outlined,
                        CurrentPwd, () {}),
                    SizedBox(
                      height: 6.0,
                    ),
                    textFieldProfile(
                        'New Password', Icons.badge_outlined, NewPwd, () {}),
                    SizedBox(
                      height: 6.0,
                    ),
                    textFieldProfile(
                        'Re Password', Icons.badge_outlined, RePwd, () {}),
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
