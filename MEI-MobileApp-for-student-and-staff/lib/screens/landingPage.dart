import 'package:flutter/material.dart';
import '../components/loginorSignupCard.dart';
import '../components/logoImageTop.dart';
import '../screens/loginScreen.dart';
import '../screens/signUpScreen.dart';

class landingPage extends StatelessWidget {
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
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextButton(
                onPressed: () {
                  Navigator.push(context, MaterialPageRoute(builder: (context) {
                    return loginScreen();
                  }));
                },
                child: loginorSignupCard("Login", 1.0)),
            TextButton(
                onPressed: () {
                  Navigator.push(context, MaterialPageRoute(builder: (context) {
                    return signUpScreen();
                  }));
                },
                child: loginorSignupCard("Sign Up", 1.0))
          ],
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
