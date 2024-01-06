import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/screens/loginScreen.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import '../components/logoImageTop.dart';
import '../components/loginorSignupCard.dart';
import 'package:http/http.dart' as http;

class newPassword extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        body: SafeArea(
          child: Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.bottomLeft,
                end: Alignment.topLeft,
                stops: [0.1, 0.5, 0.7, 0.9],
                colors: [
                  Color.fromRGBO(55, 8, 2, 2.0),
                  Color.fromRGBO(214, 128, 124, 2.0),
                  Color.fromRGBO(213, 109, 116, 0.6),
                  Color.fromRGBO(227, 204, 205, 0.6),
                ],
              ),
            ),
            child: Center(
              child: ContentInitial(),
            ),
          ),
        ),
      ),
    );
  }
}

class ContentInitial extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        LogoImageTop(Colors.white, 80.0),
        SizedBox(
          height: 10.0,
        ),
        ContentAreaAuthorization()
      ],
    );
  }
}

class ContentAreaAuthorization extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Expanded(
      child: Container(
        margin:
            EdgeInsets.only(top: 0.0, left: 20.0, right: 20.0, bottom: 20.0),
        decoration: BoxDecoration(
            color: Colors.white, borderRadius: BorderRadius.circular(20.0)),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            passwordResetForm(),
          ],
        ),
      ),
    );
  }
}

class passwordResetForm extends StatefulWidget {
  @override
  State<passwordResetForm> createState() => _passwordResetFormState();
}

class _passwordResetFormState extends State<passwordResetForm> {
  final TextEditingController newPasswordController = TextEditingController();
  final TextEditingController rePasswordController = TextEditingController();

  Future<void> updatePwd() async {
    final String npwd = newPasswordController.text;
    final String rpwd = rePasswordController.text;
    dynamic uid = await SessionManager().get("uid");

    // Reference to the Firestore collection.
    CollectionReference students =
        FirebaseFirestore.instance.collection('User');

    // Query the Firestore collection using the user-specific field (e.g., 'user_id').
    QuerySnapshot querySnapshot =
        await students.where('userID', isEqualTo: uid).get();

    // Check if any documents match the query (assuming there should be only one).
    var docId = querySnapshot.docs[0].id;

    if (npwd == rpwd) {
      String encryptedPwd = await sendPassword(npwd);
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
            builder: (context) => loginScreen(),
          ));
        }).catchError((error) {
          // Handle errors, e.g., network issues.
          print('Error updating password: $error');
        });
      }
    } else {
      print("Passwords not matched");
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

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          margin: EdgeInsets.symmetric(vertical: 5.0, horizontal: 25.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              TextFormField(
                controller: newPasswordController,
                style: TextStyle(fontSize: 20.0),
                decoration: InputDecoration(
                    hintText: 'New Password',
                    prefixIcon: Icon(
                      Icons.password,
                      color: Color.fromRGBO(147, 137, 125, 4.0),
                      size: 40.0,
                    ),
                    filled: true,
                    fillColor: Color.fromRGBO(217, 217, 217, 4.0),
                    enabledBorder: OutlineInputBorder(
                      borderSide: BorderSide(
                          width: 1, color: Colors.white), //<-- SEE HERE
                      borderRadius: BorderRadius.circular(50.0),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderSide: BorderSide(
                          width: 1, color: Colors.white), //<-- SEE HERE
                      borderRadius: BorderRadius.circular(50.0),
                    ),
                    hintStyle: TextStyle(
                      fontWeight: FontWeight.bold,
                    )),
              ),
              SizedBox(
                height: 10.0,
              ),
              TextFormField(
                controller: rePasswordController,
                style: TextStyle(fontSize: 20.0),
                decoration: InputDecoration(
                    hintText: 'Confirm Password',
                    prefixIcon: Icon(
                      Icons.password,
                      color: Color.fromRGBO(147, 137, 125, 4.0),
                      size: 40.0,
                    ),
                    filled: true,
                    fillColor: Color.fromRGBO(217, 217, 217, 4.0),
                    enabledBorder: OutlineInputBorder(
                      borderSide: BorderSide(
                          width: 1, color: Colors.white), //<-- SEE HERE
                      borderRadius: BorderRadius.circular(50.0),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderSide: BorderSide(
                          width: 1, color: Colors.white), //<-- SEE HERE
                      borderRadius: BorderRadius.circular(50.0),
                    ),
                    hintStyle: TextStyle(
                      fontWeight: FontWeight.bold,
                    )),
              ),
              TextButton(
                  onPressed: updatePwd,
                  child: loginorSignupCard("Submit and Reset", 25.0))
            ],
          ),
        )
      ],
    );
  }
}
