import 'package:flutter/material.dart';
import '../components/loginorSignupCard.dart';
import '../components/logoImageTop.dart';
import 'package:phone_form_field/phone_form_field.dart';
import '../screens/secondSignUpScreen.dart';

class signUpScreen extends StatelessWidget {
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

class FirstSignUpForm extends StatefulWidget {
  const FirstSignUpForm({super.key});

  @override
  State<FirstSignUpForm> createState() => FirstSignUpFormState();
}

class FirstSignUpFormState extends State<FirstSignUpForm> {
  TextEditingController _firstNameFormFieldController = TextEditingController();
  TextEditingController _lastNameFormFieldController = TextEditingController();
  TextEditingController _gradeFormFieldController = TextEditingController();
  PhoneController _phoneFormFieldController = PhoneController(null);
  String dropdownValue = 'Male';
  final formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          margin: EdgeInsets.symmetric(vertical: 5.0, horizontal: 25.0),
          child: Form(
            key: formKey,
            child: Column(
              children: [
                TextFormField(
                  controller: _firstNameFormFieldController,
                  validator: (value) {
                    if (value!.isEmpty ||
                        !RegExp(r'^[a-z A-Z]+$').hasMatch(value!)) {
                      return 'Enter Correct Name';
                    } else {
                      return null;
                    }
                  },
                  style: TextStyle(fontSize: 20.0),
                  decoration: InputDecoration(
                      hintText: 'First Name',
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
                  controller: _lastNameFormFieldController,
                  validator: (value) {
                    if (value!.isEmpty ||
                        !RegExp(r'^[a-z A-Z]+$').hasMatch(value!)) {
                      return 'Enter Correct Name';
                    } else {
                      return null;
                    }
                  },
                  style: TextStyle(fontSize: 20.0),
                  decoration: InputDecoration(
                      hintText: 'Last Name',
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
                  controller: _gradeFormFieldController,
                  style: TextStyle(fontSize: 20.0),
                  decoration: InputDecoration(
                      hintText: 'Grade',
                      prefixIcon: Icon(
                        Icons.school,
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
                DropdownButtonFormField<String>(
                  value: dropdownValue,
                  decoration: InputDecoration(
                      hintText: 'Gender',
                      prefixIcon: Icon(
                        Icons.man_4,
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
                  items: ['Male', 'Female']
                      .map<DropdownMenuItem<String>>((String value) {
                    return DropdownMenuItem<String>(
                      value: value,
                      child: Text(
                        value,
                        style: TextStyle(fontSize: 20),
                      ),
                    );
                  }).toList(),
                  onChanged: (String? newValue) {
                    setState(() {
                      dropdownValue = newValue!;
                    });
                  },
                ),
                SizedBox(
                  height: 5.0,
                ),
                PhoneFormField(
                  controller: _phoneFormFieldController,
                  defaultCountry: IsoCode.LK,
                  decoration: InputDecoration(
                      hintText: 'Phone Number',
                      prefixIcon: Icon(
                        Icons.phone,
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
                TextButton(
                    onPressed: () {
                      if (formKey.currentState!.validate()) {
                        Navigator.push(context,
                            MaterialPageRoute(builder: (context) {
                          return secondSignUpScreen([
                            _firstNameFormFieldController.text,
                            _lastNameFormFieldController.text,
                            _gradeFormFieldController.text,
                            _phoneFormFieldController.value.toString(),
                            dropdownValue
                          ]);
                        }));
                        print(
                            _phoneFormFieldController.initialValue.toString());
                      }
                    },
                    style: TextButton.styleFrom(padding: EdgeInsets.zero),
                    child: loginorSignupCard("Next", 1.0)),
              ],
            ),
          ),
        )
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
        child: Center(
          child: SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                FirstSignUpForm(),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
