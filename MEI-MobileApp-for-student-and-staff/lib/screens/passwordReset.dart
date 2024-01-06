import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/screens/otpConfirm.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import '../components/logoImageTop.dart';
import '../components/loginorSignupCard.dart';
import 'package:flutter/material.dart';
import 'package:mailer/mailer.dart';
import 'package:mailer/smtp_server.dart';
import 'dart:math';

class passwordReset extends StatelessWidget {
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
  final TextEditingController emailController = TextEditingController();

  Future<void> _check_email() async {
    final String email = emailController.text;
    const String status = 'active';
    final QuerySnapshot studentSnapshot = await FirebaseFirestore.instance
        .collection('student')
        .where('Email', isEqualTo: email)
        .where('Status', isEqualTo: status)
        .get();

    final QuerySnapshot staffSnapshot = await FirebaseFirestore.instance
        .collection('staff')
        .where('Email', isEqualTo: email)
        .where('Status', isEqualTo: status)
        .get();
    int uid = 0;
    if (studentSnapshot.docs.isNotEmpty) {
      final DocumentSnapshot studentDocument = studentSnapshot.docs.first;
      uid = studentDocument['UID'];
    } else if (staffSnapshot.docs.isNotEmpty) {
      final DocumentSnapshot staffDocument = staffSnapshot.docs.first;
      uid = staffDocument['UId'];
    }

    if (uid == 0) {
      print("Invalid Email");
    } else {
      await sendEmail(email);
      await SessionManager().set("uid", uid);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          margin: EdgeInsets.symmetric(vertical: 5.0, horizontal: 25.0),
          child: Column(
            children: [
              TextFormField(
                controller: emailController,
                style: TextStyle(fontSize: 20.0),
                decoration: InputDecoration(
                    hintText: 'Email',
                    prefixIcon: Icon(
                      Icons.email,
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
                  onPressed: _check_email,
                  child: loginorSignupCard("Send OTP", 25.0)),
            ],
          ),
        )
      ],
    );
  }

  Future<void> sendEmail(String email) async {
    Random random = Random();
    // Generate a random number in the range 100,000 to 999,999 (inclusive)
    int randomNumber = 100000 + random.nextInt(900000);
    String otp = randomNumber.toString();

    await SessionManager().set("otp", otp);

    final smtpServer = gmail('mercyeducationinstitute@gmail.com', 'lizqvaxonrsowtzf');

    final message = Message()
      ..from = Address('mercyeducationinstitute@gmail.com')
      ..recipients.add(email)
      ..subject = 'Verification Code'
      ..text = otp;

    try {
      final sendReport = await send(message, smtpServer);
      print('Message sent: ${sendReport.toString()}');
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => otpConfirm()),
      );
    } on MailerException catch (e) {
      print('Message not sent. Error: $e');
    }
  }
}
