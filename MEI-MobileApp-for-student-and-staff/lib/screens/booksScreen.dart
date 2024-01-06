import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/provider/favourite_provider.dart';
import 'package:elibrary_frontend/screens/bookDetails.dart';
import 'package:elibrary_frontend/widgets/screenTopic.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:provider/provider.dart';
import 'package:cloud_firestore/cloud_firestore.dart';
import '../components/NavBar.dart';
import '../data/bookData.dart';
import 'pdf_view_page.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:http/http.dart' as http;
import 'dart:io';

class booksScreen extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _booksScreenState();
  }
}

class _booksScreenState extends State<booksScreen> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  @override
  Widget build(BuildContext context) {
    final provider = Provider.of<FavouriteProvider>(context);
    return StreamBuilder<QuerySnapshot>(
        stream: FirebaseFirestore.instance
            .collection('book')
            .where('status', isEqualTo: 'active')
            .orderBy('bookId')
            .snapshots(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return CircularProgressIndicator();
          }

          if (snapshot.hasError) {
            return Text('Error: ${snapshot.error}');
          }

          final booksData = snapshot.data!.docs;

          final books = booksData.map((bookDoc) {
            final bookData = bookDoc.data() as Map<String, dynamic>;
            return BookData(
              bookData['Image'],
              bookData['Title'],
              bookData['Author'],
              bookData['bookId'],
              bookData['Link'],
              bookData['Category'],
              bookData['year'],
            );
          }).toList();

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
                          children: [
                            screenTopic("Books"),
                            SizedBox(
                              height: 10.0,
                            ),
                            Flexible(
                                child: ListView.builder(
                                    itemCount: books.length,
                                    itemBuilder: (context, index) {
                                      final book = books[index];
                                      return Column(
                                        children: [
                                          Row(
                                            mainAxisAlignment:
                                                MainAxisAlignment.spaceBetween,
                                            children: [
                                              Column(
                                                children: [
                                                  InkWell(
                                                    child: Container(
                                                      width: 121.66,
                                                      height: 180.5,
                                                      decoration: BoxDecoration(
                                                          borderRadius:
                                                              BorderRadius
                                                                  .circular(
                                                                      8.0),
                                                          image:
                                                              DecorationImage(
                                                            image: NetworkImage(
                                                                '${book.bookCover}'),
                                                            fit: BoxFit.cover,
                                                          )),
                                                    ),
                                                    onTap: () {
                                                      Navigator.push(
                                                          context,
                                                          MaterialPageRoute(
                                                              builder:
                                                                  (context) =>
                                                                      bookDetails(
                                                                        books: books[
                                                                            index],
                                                                      )));
                                                    },
                                                  ),
                                                  FutureBuilder<double>(
                                                    future:
                                                        avgRating(book.bookId),
                                                    builder:
                                                        (context, snapshot) {
                                                      if (snapshot
                                                              .connectionState ==
                                                          ConnectionState
                                                              .waiting) {
                                                        return CircularProgressIndicator();
                                                      }
                                                      double rating =
                                                          snapshot.data ?? 0.0;
                                                      return RatingBarIndicator(
                                                        itemBuilder:
                                                            (context, index) =>
                                                                Icon(
                                                          Icons.star,
                                                          color:
                                                              Color(0xffcf1a26),
                                                        ),
                                                        rating: rating,
                                                        itemCount: 5,
                                                        itemSize: 23.0,
                                                        direction:
                                                            Axis.horizontal,
                                                      );
                                                    },
                                                  ),
                                                ],
                                              ),
                                              SizedBox(width: 20.0),
                                              Expanded(
                                                child: Column(children: [
                                                  Text(
                                                    book.bookName,
                                                    style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.w900,
                                                        color:
                                                            Color(0xffa0978d)),
                                                  ),
                                                  Text(
                                                    book.author,
                                                    style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.w900,
                                                        color:
                                                            Color(0xffa0978d)),
                                                  ),
                                                  Text(
                                                    book.category,
                                                    style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.w900,
                                                        color:
                                                            Color(0xffa0978d)),
                                                  ),
                                                  Text(
                                                    book.year,
                                                    style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.w900,
                                                        color:
                                                            Color(0xffa0978d)),
                                                  ),
                                                  Row(
                                                    mainAxisAlignment:
                                                        MainAxisAlignment
                                                            .spaceBetween,
                                                    children: [
                                                      IconButton(
                                                        onPressed: () async {
                                                          toggleFavourite(
                                                              book.bookId);
                                                        },
                                                        icon:
                                                            FutureBuilder<bool>(
                                                          future: isExist(
                                                              book.bookId),
                                                          builder: (BuildContext
                                                                  context,
                                                              AsyncSnapshot<
                                                                      bool>
                                                                  snapshot) {
                                                            if (snapshot
                                                                    .connectionState ==
                                                                ConnectionState
                                                                    .waiting) {
                                                              return CircularProgressIndicator();
                                                            } else if (snapshot
                                                                .hasError) {
                                                              return Icon(
                                                                  Icons.error);
                                                            } else {
                                                              return Icon(
                                                                snapshot.data!
                                                                    ? Icons
                                                                        .favorite
                                                                    : Icons
                                                                        .favorite_border,
                                                                size: 35.0,
                                                                color: Color(
                                                                    0xffcf1a26),
                                                              );
                                                            }
                                                          },
                                                        ),
                                                      ),
                                                      Column(
                                                        children: [
                                                          IconButton(
                                                              onPressed: () {
                                                                downloadPDF(
                                                                    book.link,
                                                                    book.bookName);
                                                              },
                                                              icon: Icon(
                                                                  Icons
                                                                      .download,
                                                                  size: 40.0,
                                                                  color: Color(
                                                                      0xffcf1a26))),
                                                          Text(
                                                            'Download',
                                                            style: TextStyle(
                                                                fontWeight:
                                                                    FontWeight
                                                                        .w900,
                                                                color: Color(
                                                                    0xffa0978d)),
                                                          )
                                                        ],
                                                      )
                                                    ],
                                                  ),
                                                ]),
                                              ),
                                            ],
                                          ),
                                          SizedBox(
                                            height: 10.0,
                                          )
                                        ],
                                      );
                                    })),
                          ],
                        ))))
              ],
            )),
          );
        });
  }

  Future<double> avgRating(int bookId) async {
    double avg = 0.0;
    int count = 0;
    double sum = 0;
    // Reference to the feedback collection for the given book
    CollectionReference feedbackCollection =
        FirebaseFirestore.instance.collection('feedback');

    // Query the feedback collection to get feedback for the given book
    QuerySnapshot querySnapshot =
        await feedbackCollection.where('bookId', isEqualTo: bookId).get();

    // Iterate through the feedback documents
    for (QueryDocumentSnapshot feedbackDoc in querySnapshot.docs) {
      // Assuming you have a field named 'rating' in each feedback document
      sum = sum + feedbackDoc.get('rating');
      count++;
    }

    // Calculate the average rating
    if (count == 0) {
      avg = 0;
    } else {
      avg = sum / count;
    }
    //print('Average Rating: $avg');
    return avg;
  }

/*
  Future<void> launchLink(String url, {bool isNewTab = true}) async {
  Uri uri = Uri.parse(url);
  await launchUrl(
    uri,
    webOnlyWindowName: isNewTab ? '_blank' : '_self',
  );
  }
*/
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

  void addFav(int bookId) async {
    try {
      dynamic id = await SessionManager().get("user");

      DocumentReference docRef =
          FirebaseFirestore.instance.collection('fav').doc();

      await docRef.set({
        'UID': id,
        'BID': bookId,
      });

      print('Book added to favourites.');
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => booksScreen()),
      );
    } catch (e) {
      print('Error adding to favourites: $e');
    }
  }

  void removeFav(int bookId) async {
    try {
      dynamic id = await SessionManager().get("user");

      QuerySnapshot querySnapshot = await FirebaseFirestore.instance
          .collection('fav')
          .where('UID', isEqualTo: id)
          .where('BID', isEqualTo: bookId)
          .get();

      DocumentReference docRef = querySnapshot.docs[0].reference;
      await docRef.delete();

      print('Book removed from favouritese.');
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => booksScreen()),
      );
    } catch (e) {
      print('Error removing book from favourites: $e');
    }
  }

  void toggleFavourite(int bookId) {
    dynamic id = SessionManager().get("user");

    FirebaseFirestore.instance
        .collection('fav')
        .where('UID', isEqualTo: id)
        .where('BID', isEqualTo: bookId)
        .get()
        .then((QuerySnapshot<Object?> snapshot) {
      if (snapshot.docs.isNotEmpty) {
        removeFav(bookId);
      } else {
        addFav(bookId);
      }
    });
  }

  Future<bool> isExist(int bookId) async {
    dynamic id = await SessionManager().get("user");

    QuerySnapshot querySnapshot = await FirebaseFirestore.instance
        .collection('fav')
        .where('UID', isEqualTo: id)
        .where('BID', isEqualTo: bookId)
        .get();

    return querySnapshot.docs.isNotEmpty;
  }
}
