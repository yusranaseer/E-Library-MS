import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/screens/dashBoard.dart';
import 'package:elibrary_frontend/screens/passwordReset.dart';
import 'package:flutter/material.dart';
import '../components/loginorSignupCard.dart';
import '../components/logoImageTop.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:flutter/material.dart';
import 'package:mailer/mailer.dart';
import 'package:mailer/smtp_server.dart';
import 'package:http/http.dart' as http;

class loginScreen extends StatelessWidget {
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
            loginform(),
          ],
        ),
      ),
    );
  }
}

class loginform extends StatefulWidget {
  const loginform({super.key});

  @override
  State<loginform> createState() => _loginformState();
}

class _loginformState extends State<loginform> {
  //db
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  Future<void> _login() async {
    final String username = usernameController.text;
    final String password = passwordController.text;
    const String status = 'active';
    String type = '';
    final QuerySnapshot studentSnapshot = await FirebaseFirestore.instance
        .collection('student')
        .where('username', isEqualTo: username)
        .where('Status', isEqualTo: status)
        .get();

    final QuerySnapshot staffSnapshot = await FirebaseFirestore.instance
        .collection('staff')
        .where('username', isEqualTo: username)
        .where('Status', isEqualTo: status)
        .get();
    int uid = 0;
    if (studentSnapshot.docs.isNotEmpty) {
      final DocumentSnapshot studentDocument = studentSnapshot.docs.first;
      uid = studentDocument['UID'];
      type = 'student';
    } else if (staffSnapshot.docs.isNotEmpty) {
      final DocumentSnapshot staffDocument = staffSnapshot.docs.first;
      uid = staffDocument['UId'];
      type = 'staff';
    } else {
      // No matching user found
      print("User not found");
    }
    print(password);
    print(uid);
    int confirmPwd = await verifyPassword(uid, password);
    print(confirmPwd);
    if (confirmPwd == 1) {
      // Successful login
      print('Login successful');
      //session
      await SessionManager().set("user", uid);
      await SessionManager().set("usertype", type);

      dynamic id = await SessionManager().get("user");
      print(id);

      dynamic utype = await SessionManager().get("usertype");
      print(utype);

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
            builder: (context) =>
                dashBoard1()), // Replace NextScreen with the actual screen you want to navigate to
      );

      // Here you can navigate to the next screen or perform any other actions
    } else if (confirmPwd == 0) {
      // Incorrect password
      print('Incorrect password');
    } else {
      print('HTTP REQ problem');
    }
  }
  //db end

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        // Note: Same code is applied for the TextFormField as well
        Container(
          margin: EdgeInsets.symmetric(vertical: 5.0, horizontal: 25.0),
          child: Column(
            children: [
              TextFormField(
                controller: usernameController,
                style: TextStyle(fontSize: 20.0),
                decoration: InputDecoration(
                    hintText: 'Username',
                    prefixIcon: Icon(
                      Icons.person,
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
                controller: passwordController,
                obscureText: true,
                style: TextStyle(fontSize: 20.0),
                decoration: InputDecoration(
                    hintText: 'Password',
                    prefixIcon: Icon(
                      Icons.lock,
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
                  onPressed: _login, child: loginorSignupCard("Login", 25.0)),
              Align(
                alignment: Alignment.centerRight,
                child: TextButton(
                  onPressed: () {
                    Navigator.push(context,
                        MaterialPageRoute(builder: (context) {
                      return passwordReset();
                    }));
                  },
                  child: Text(
                    "Forgot Password?",
                    style: TextStyle(
                        fontWeight: FontWeight.w900,
                        color: Color.fromRGBO(201, 196, 190, 4.0)),
                  ),
                ),
              )
            ],
          ),
        )
      ],
    );
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
}
