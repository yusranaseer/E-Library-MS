import 'dart:io';

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/NavBar.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/booksScreen.dart';
import 'package:elibrary_frontend/screens/pdf_view_page.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';

import '../data/bookData.dart';

class bookDetails extends StatefulWidget {
  const bookDetails({super.key, required this.books});

  final BookData books;

  @override
  State<bookDetails> createState() => _bookDetailsState();
}

class _bookDetailsState extends State<bookDetails> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  TextEditingController feedbackController = TextEditingController();
  double currentRating = 0.0;

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
            child: Column(children: [
              screenTopic(widget.books.bookName),
              SizedBox(
                height: 10.0,
              ),
              Text(
                'Written by ${widget.books.author}',
                style: TextStyle(
                    fontWeight: FontWeight.w900, color: Color(0xffa0978d)),
              ),
              Text(
                '${widget.books.category} Category',
                style: TextStyle(
                    fontWeight: FontWeight.w900, color: Color(0xffa0978d)),
              ),
              Text(
                'Published in ${widget.books.year}',
                style: TextStyle(
                    fontWeight: FontWeight.w900, color: Color(0xffa0978d)),
              ),
              SizedBox(
                height: 10.0,
              ),
              Flexible(
                  child: SingleChildScrollView(
                child: Column(
                  children: [
                    Container(
                      width: 230.0,
                      height: 352.66666666667,
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8.0),
                          image: DecorationImage(
                            image: NetworkImage(widget.books.bookCover),
                            fit: BoxFit.cover,
                          )),
                    ),
                    Divider(
                      color: Color.fromARGB(17, 255, 255, 255),
                      height: 25,
                      thickness: 5,
                      indent: 5,
                      endIndent: 5,
                    ),
                    Align(
                      alignment: Alignment.centerLeft,
                      child: Text(
                        'Rate this Book',
                        style: TextStyle(
                            fontSize: 25.0, fontWeight: FontWeight.w900),
                      ),
                    ),
                    RatingBar.builder(
                      initialRating: 3,
                      minRating: 1,
                      direction: Axis.horizontal,
                      allowHalfRating: true,
                      itemCount: 5,
                      itemPadding: EdgeInsets.symmetric(horizontal: 4.0),
                      itemBuilder: (context, _) => Icon(
                        Icons.star,
                        color: Colors.amber,
                      ),
                      onRatingUpdate: (rating) {
                        setState(() {
                          currentRating = rating;
                        });
                      },
                    ),
                    Container(
                      width: double.infinity,
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(20),
                          border: Border.all(
                              width: 5,
                              color: Colors.black38,
                              style: BorderStyle.solid)),
                      child: TextField(
                        controller: feedbackController,
                        maxLines: 5,
                        style: TextStyle(fontWeight: FontWeight.w500),
                        textAlign: TextAlign.center,
                      ),
                    ),
                    SizedBox(
                      height: 10.0,
                    ),
                    ElevatedButton.icon(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Color(0xffcf1a26),
                        minimumSize: const Size.fromHeight(50), // NEW
                      ),
                      // <-- ElevatedButton
                      onPressed: () {
                        addFeedback(widget.books.bookId);
                      },
                      icon: Icon(
                        Icons.send,
                        size: 24.0,
                      ),
                      label: Text('Submit Feedback',
                          style: TextStyle(fontWeight: FontWeight.w800)),
                    ),
                    SizedBox(
                      height: 10.0,
                    ),
                    ElevatedButton.icon(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Color(0xffcf1a26),
                        minimumSize: const Size.fromHeight(50), // NEW
                      ),
                      // <-- ElevatedButton
                      onPressed: () {
                        downloadPDF(widget.books.link, widget.books.bookName);
                      },
                      icon: Icon(
                        Icons.download,
                        size: 24.0,
                      ),
                      label: Text('Download',
                          style: TextStyle(fontWeight: FontWeight.w800)),
                    ),
                  ],
                ),
              ))
            ]),
          )))
        ],
      )),
    );
  }

  Future<void> downloadPDF(String url, String name) async {
    final pdfUrl = url; // Replace with your Firebase Storage URL
    final response = await http.get(Uri.parse(pdfUrl));

    if (response.statusCode == 200) {
      // Save the downloaded PDF to a local file
      final filePath =
          '/storage/emulated/0/Download/$name.pdf'; // Set the desired file path
      final file = File(filePath);
      await file.writeAsBytes(response.bodyBytes);

      // Now, you can open or view the downloaded PDF using a PDF viewer.
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => PDFViewPage(pdfUrl: filePath)),
      );
    } else {
      // Handle the error, e.g., file not found or unauthorized access.
    }
  }

  Future<void> addFeedback(int bookId) async {
    final String feedback = feedbackController.text;
    double rating = currentRating;
    dynamic id = await SessionManager().get("user");
    int userId = id;
    int feedbackId = await feedbackid();
    // Firestore instance
    final FirebaseFirestore _firestore = FirebaseFirestore.instance;

    // Firestore collection reference
    CollectionReference feedbackCollection = _firestore.collection('feedback');

    // Add data to Firestore
    feedbackCollection.add({
      'bookId': bookId,
      'feedback': feedback,
      'feedbackId': feedbackId,
      'rating': rating,
      'userId': userId,
    }).then((value) {
      // Feedback added successfully
      print('Feedback added to Firestore');
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => booksScreen()),
      );
      // You can display a success message or navigate to another screen.
    }).catchError((error) {
      // Handle errors, e.g., display an error message
      print('Error adding feedback: $error');
    });
  }

  Future<int> feedbackid() async {
    try {
      await Firebase.initializeApp();

      QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
          .collection('feedback')
          .orderBy('feedbackId', descending: true)
          .get();
      int feedbackid = 1;
      if (taskSnapshot.docs.isNotEmpty) {
        setState(() {
          feedbackid = taskSnapshot.docs[0]['feedbackId'] + 1;
        });
        return feedbackid;
      } else {
        print('First Feedback');
        return 1;
      }
    } catch (e) {
      print('Error fetching feedback data: $e');
      return 0;
    }
  }
}
