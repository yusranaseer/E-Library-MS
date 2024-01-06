import 'package:elibrary_frontend/screens/newPassword.dart';
import 'package:elibrary_frontend/screens/passwordReset.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import '../components/logoImageTop.dart';
import '../components/loginorSignupCard.dart';

class otpConfirm extends StatelessWidget {
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
  final TextEditingController otpController = TextEditingController();

  Future<void> _verify_otp() async {
    final String otpString = otpController.text.toString();
    dynamic verification = await SessionManager().get("otp");
    int otp = int.parse(otpString);

    if (otp == verification) {
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => newPassword()),
      );
    } else {
      print("Invalid OTP. Try Again");
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => passwordReset()),
      );
    }
    SessionManager().remove("otp");
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
                controller: otpController,
                style: TextStyle(fontSize: 20.0),
                decoration: InputDecoration(
                    hintText: 'OTP',
                    prefixIcon: Icon(
                      Icons.vpn_key,
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
                  onPressed: _verify_otp,
                  child: loginorSignupCard("Verify OTP", 25.0)),
            ],
          ),
        )
      ],
    );
  }
}
