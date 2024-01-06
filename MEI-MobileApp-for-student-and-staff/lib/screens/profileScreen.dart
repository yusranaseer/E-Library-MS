import 'dart:io';

import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/editEmail.dart';
import 'package:elibrary_frontend/screens/editPassword.dart';
import 'package:elibrary_frontend/screens/editAddress.dart';
import 'package:elibrary_frontend/screens/editProfileName.dart';
import 'package:elibrary_frontend/screens/editUsername.dart';
import 'package:elibrary_frontend/widgets/circleAvatar.dart';
import 'package:elibrary_frontend/widgets/phoneFormFieldProfile.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:elibrary_frontend/widgets/textFieldProfile.dart';
import 'package:file_picker/file_picker.dart';
import 'package:firebase_storage/firebase_storage.dart';
import 'package:flutter/material.dart';
import 'package:phone_form_field/phone_form_field.dart';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import '../components/NavBar.dart';
import 'loginScreen.dart';
import 'dart:typed_data';
import 'package:http/http.dart' as http;

class profileScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _profileScreenState();
  }
}

class _profileScreenState extends State<profileScreen> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  Uint8List? _image;
  TextEditingController fullnameController = TextEditingController();
  TextEditingController emailController = TextEditingController();
  PhoneController phoneFormFieldController = PhoneController(null);
  TextEditingController addressController = TextEditingController();
  TextEditingController usernameController = TextEditingController();

  @override
  void initState() {
    //dynamic utype = await SessionManager().get("usertype");
    super.initState();
    checkSession();
    someFunction(); // Fetch data when the widget is initialized
  }

  void checkSession() async {
    // Check if the user is logged in or if the session variable is set.
    dynamic id = await SessionManager().get("user");

    if (id == "") {
      // If not logged in, redirect to the admin login screen.
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => loginScreen()),
      );
    }
  }

  void someFunction() async {
    dynamic id = await SessionManager().get("user"); // Use await here
    print(id);
    dynamic type = await SessionManager().get("usertype");
    try {
      if (type == 'student') {
        // Call getUserDetails and await the result
        await getUserDetails(id);
      } else if (type == 'staff') {
        // Call getStaffDetails and await the result
        await getStaffDetails(id);
      } else {
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(
              builder: (context) =>
                  loginScreen()), // Replace NextScreen with the actual screen you want to navigate to
        );
      }
    } catch (e) {
      // Handle any errors that occur during the getUserDetails call
      print('Error fetching user details: $e');
    }
  }

  Future<void> getStaffDetails(int userId) async {
    try {
      final CollectionReference usersCollection =
          FirebaseFirestore.instance.collection('staff');

      // Query for documents where the "userId" field matches the provided userId
      QuerySnapshot querySnapshot =
          await usersCollection.where('UId', isEqualTo: userId).get();

      if (querySnapshot.docs.isNotEmpty) {
        // Assuming there's only one matching user, retrieve the first document
        DocumentSnapshot userSnapshot = querySnapshot.docs[0];

        // Access user data from the document
        Map<String, dynamic> userData =
            userSnapshot.data() as Map<String, dynamic>;

        // Now, you can access specific user details using userData
        String fullname = userData['Name'];
        String email = userData['Email'];
        int contact = userData['Contact'];
        String addr = userData['Address'];
        String username = userData['username'];
        // Access the image URL from the userData
        String imgURL = userData['img'];

        // Fetch the image and set it to _image
        Uint8List? imageBytes = await fetchImageFromURL(imgURL);

        // Set the imageBytes to _image and call setState to rebuild the widget
        setState(() {
          _image = imageBytes;
        });

        String cn = contact.toString();
        // Do something with the user details
        fullnameController.text = fullname;
        emailController.text = email;
        phoneFormFieldController.value =
            PhoneNumber(isoCode: IsoCode.LK, nsn: cn);

        addressController.text = addr;
        usernameController.text = username;
      } else {
        print('User with userId $userId does not exist.');
      }
    } catch (e) {
      print('Error getting user details: $e');
    }
  }

  Future<void> getUserDetails(int userId) async {
    try {
      final CollectionReference usersCollection =
          FirebaseFirestore.instance.collection('student');

      // Query for documents where the "userId" field matches the provided userId
      QuerySnapshot querySnapshot =
          await usersCollection.where('UID', isEqualTo: userId).get();

      if (querySnapshot.docs.isNotEmpty) {
        // Assuming there's only one matching user, retrieve the first document
        DocumentSnapshot userSnapshot = querySnapshot.docs[0];

        // Access user data from the document
        Map<String, dynamic> userData =
            userSnapshot.data() as Map<String, dynamic>;

        // Now, you can access specific user details using userData
        String fullname = userData['First_Name'] + " " + userData['Last_Name'];
        String email = userData['Email'];
        int contact = userData['Contact'];
        String addr = userData['Address'];
        String username = userData['username'];
        // Access the image URL from the userData
        String imgURL = userData['img'];

        // Fetch the image and set it to _image
        Uint8List? imageBytes = await fetchImageFromURL(imgURL);

        // Set the imageBytes to _image and call setState to rebuild the widget
        setState(() {
          _image = imageBytes;
        });

        String cn = contact.toString();
        // Do something with the user details
        fullnameController.text = fullname;
        emailController.text = email;
        phoneFormFieldController.value =
            PhoneNumber(isoCode: IsoCode.LK, nsn: cn);

        addressController.text = addr;
        usernameController.text = username;
      } else {
        print('User with userId $userId does not exist.');
      }
    } catch (e) {
      print('Error getting user details: $e');
    }
  }

// Function to fetch image bytes from URL
  Future<Uint8List?> fetchImageFromURL(String url) async {
    try {
      http.Response response = await http.get(Uri.parse(url));
      if (response.statusCode == 200) {
        return response.bodyBytes;
      } else {
        print('Failed to fetch image from URL: ${response.statusCode}');
        return null;
      }
    } catch (e) {
      print('Error fetching image: $e');
      return null;
    }
  }

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
            child: SingleChildScrollView(
              child: Column(
                children: [
                  screenTopic("Profile"),
                  SizedBox(
                    height: 10.0,
                  ),
                  Stack(children: [
                    _image != null
                        ? CircleAvatar(
                            radius: 65.0,
                            backgroundImage: MemoryImage(_image!),
                          )
                        : CircleAvatar(
                            radius: 65.0,
                            backgroundImage: NetworkImage(
                                'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNL_ZnOTpXSvhf1UaK7beHey2BX42U6solRA&usqp=CAU')),
                    Positioned(
                        child: IconButton(
                            onPressed: () async {
                              final result =
                                  await FilePicker.platform.pickFiles(
                                allowMultiple: true,
                              );
                              if (result == null) return;

                              handleFileUpload(result.files);
                            },
                            icon: Icon(
                              size: 30.0,
                              Icons.add_a_photo,
                              color: Color(0xffcf1a26),
                            )),
                        bottom: -10,
                        left: 80),
                  ]),
                  Column(
                    children: [
                      textFieldProfile(
                          'Username', Icons.account_circle, usernameController,
                          () {
                        Navigator.push(context,
                            MaterialPageRoute(builder: (context) {
                          return editUsername();
                        }));
                      }),
                      SizedBox(
                        height: 10.0,
                      ),
                      textFieldProfile(
                          'Full Name', Icons.account_circle, fullnameController,
                          () {
                        Navigator.push(context,
                            MaterialPageRoute(builder: (context) {
                          return editProfileName();
                        }));
                      }),
                      SizedBox(
                        height: 10.0,
                      ),
                      textFieldProfile('E-mail', Icons.mail, emailController,
                          () {
                        Navigator.push(context,
                            MaterialPageRoute(builder: (context) {
                          return editEmail();
                        }));
                      }),
                      SizedBox(
                        height: 10.0,
                      ),
                      phoneFormFieldProfile(
                          'Phone Number', Icons.phone, phoneFormFieldController,
                          () {
                        Navigator.push(context,
                            MaterialPageRoute(builder: (context) {
                          return editAddress();
                        }));
                      }),
                      SizedBox(
                        height: 10.0,
                      ),
                      textFieldProfile(
                          'Address', Icons.location_history, addressController,
                          () {
                        Navigator.push(context,
                            MaterialPageRoute(builder: (context) {
                          return editAddress();
                        }));
                      }),
                      ElevatedButton(
                        onPressed: () {
                          Navigator.push(context,
                              MaterialPageRoute(builder: (context) {
                            return editPassword();
                          }));
                        },
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Color.fromARGB(255, 183, 44,
                              92), // Set the button's background color
                        ),
                        child: Row(
                          children: [
                            Icon(Icons
                                .account_circle), // Add an icon to the button
                            SizedBox(
                                width:
                                    10), // Add some space between the icon and text
                            Text(
                                'Update Password'), // Add the text for the button
                          ],
                        ),
                      ),
                    ],
                  )
                ],
              ),
            ),
          )))
        ],
      )),
    );
  }

  void addFileToFirestore(String taskFilePath) async {
    try {
      dynamic id = await SessionManager().get("user");
      dynamic type = await SessionManager().get("usertype");

      if (type == 'student') {
        QuerySnapshot querySnapshot = await FirebaseFirestore.instance
            .collection('student')
            .where('UID', isEqualTo: id)
            .get();

        DocumentReference docRef = querySnapshot.docs[0].reference;
        await docRef.update({
          'img': taskFilePath,
        });
      } else {
        QuerySnapshot querySnapshot = await FirebaseFirestore.instance
            .collection('staff')
            .where('UId', isEqualTo: id)
            .get();

        DocumentReference docRef = querySnapshot.docs[0].reference;
        await docRef.update({
          'img': taskFilePath,
        });
      }

      print('File details updated to Firestore.');
    } catch (e) {
      print('Error updating file details to Firestore: $e');
    }
  }

  Future<String> uploadFileToFirestore(String filePath, String fileName) async {
    try {
      final Reference storageReference =
          FirebaseStorage.instance.ref('img/$fileName');
      final File file = File(filePath);

      UploadTask uploadTask = storageReference.putFile(file);
      await uploadTask;

      String downloadURL = await storageReference.getDownloadURL();

      return downloadURL;
    } catch (e) {
      print('Error uploading file to Firestore: $e');
      return "null";
    }
  }

  void handleFileUpload(List<PlatformFile> files) async {
    if (files.isNotEmpty) {
      PlatformFile file = files.first;
      String localAssetPath =
          await uploadFileToFirestore(file.path!, file.name);

      if (localAssetPath != "null") {
        addFileToFirestore(localAssetPath);
        print('File uploaded and details added to Firestore.');
      } else {
        print("Error: " + localAssetPath);
      }
    }
  }
}
