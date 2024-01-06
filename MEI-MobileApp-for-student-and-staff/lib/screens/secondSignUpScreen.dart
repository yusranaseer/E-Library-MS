import 'package:flutter/material.dart';
import '../components/loginorSignupCard.dart';
import '../components/logoImageTop.dart';

class secondSignUpScreen extends StatelessWidget {
  final List<String> previousFields;

  secondSignUpScreen(this.previousFields);

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
              child: ContentInitial(previousFields),
            ),
          ),
        ),
      ),
    );
  }
}

class ContentInitial extends StatelessWidget {
  final List<String> previousFields;

  ContentInitial(this.previousFields);

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        LogoImageTop(Colors.white, 80.0),
        SizedBox(
          height: 10.0,
        ),
        ContentAreaAuthorization(previousFields)
      ],
    );
  }
}

class ContentAreaAuthorization extends StatelessWidget {
  final List<String> previousFields;

  ContentAreaAuthorization(this.previousFields);

  final List<String> alldata = [];

  @override
  Widget build(BuildContext context) {
    return Expanded(
      child: Container(
        margin:
            EdgeInsets.only(top: 0.0, left: 20.0, right: 20.0, bottom: 20.0),
        decoration: BoxDecoration(
            color: Colors.white, borderRadius: BorderRadius.circular(20.0)),
        child: Center(
          child: SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                secondSignUpForm(previousFields),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

class secondSignUpForm extends StatefulWidget {
  final List<String> previousFields;

  secondSignUpForm(this.previousFields);

  @override
  State<StatefulWidget> createState() {
    return secondSignUpScreenState(previousFields);
  }
}

class secondSignUpScreenState extends State<secondSignUpForm> {
  final List<String> previousFields;
  final formKey = GlobalKey<FormState>();

  secondSignUpScreenState(this.previousFields);

  final List<String> alldata = [];

  TextEditingController _userNameFormFieldController = TextEditingController();

  TextEditingController _passwordFormFieldController = TextEditingController();

  TextEditingController _emailFormFieldController = TextEditingController();

  TextEditingController _confirmFormFieldController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        // Note: Same code is applied for the TextFormField as well
        Container(
          margin: EdgeInsets.symmetric(vertical: 5.0, horizontal: 25.0),
          child: Form(
            key: formKey,
            child: Column(
              children: [
                TextFormField(
                  controller: _userNameFormFieldController,
                  style: TextStyle(fontSize: 20.0),
                  decoration: InputDecoration(
                      hintText: 'User name',
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
                  height: 5.0,
                ),
                TextFormField(
                  controller: _emailFormFieldController,
                  validator: (value) {
                    if (value!.isEmpty ||
                        !RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w]{2,4}')
                            .hasMatch(value!)) {
                      return 'Enter Correct Email';
                    } else {
                      return null;
                    }
                  },
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
                SizedBox(
                  height: 5.0,
                ),
                TextFormField(
                  controller: _passwordFormFieldController,
                  validator: (value) {
                    if (value!.isEmpty) {
                      return 'Please enter some text';
                    }
                    return null;
                  },
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
                SizedBox(
                  height: 5.0,
                ),
                TextFormField(
                  controller: _confirmFormFieldController,
                  style: TextStyle(fontSize: 20.0),
                  validator: (value) {
                    if (value!.isEmpty) {
                      return 'Please re-enter password';
                    }
                    print(_passwordFormFieldController.text);
                    print(_confirmFormFieldController.text);
                    if (_passwordFormFieldController.text !=
                        _confirmFormFieldController.text) {
                      return "Password does not match";
                    }
                    return null;
                  },
                  decoration: InputDecoration(
                      hintText: 'Confirm Password',
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
                SizedBox(
                  height: 5.0,
                ),
                TextButton(
                    onPressed: () {
                      if (formKey.currentState!.validate()) {
                        addData();
                        print(alldata);
                      }
                    },
                    child: loginorSignupCard("Signup", 0.0))
              ],
            ),
          ),
        )
      ],
    );
  }

  void addData() {
    alldata.addAll(previousFields);
    alldata.addAll([
      _userNameFormFieldController.text,
      _passwordFormFieldController.text,
      _emailFormFieldController.text,
    ]);
  }
}
