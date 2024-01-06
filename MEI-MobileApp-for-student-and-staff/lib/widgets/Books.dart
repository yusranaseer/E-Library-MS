import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/data/bookData.dart';
import 'package:elibrary_frontend/screens/dashBoard.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:path/path.dart';
import 'package:provider/provider.dart';
import '../provider/favourite_provider.dart';

class Book extends StatelessWidget {
  BookID book;

  Book(this.book);

  Future<String> name(int bookId) async {
    try {
      QuerySnapshot querySnapshot = await FirebaseFirestore.instance
          .collection('book')
          .where('bookId', isEqualTo: bookId)
          .get();

      if (querySnapshot.docs.isNotEmpty) {
        return querySnapshot.docs[0]['Title'];
      }
      return "null";
    } catch (e) {
      print('Error: $e');
      return "null";
    }
  }

  Future<String> image(int bookId) async {
    try {
      QuerySnapshot querySnapshot = await FirebaseFirestore.instance
          .collection('book')
          .where('bookId', isEqualTo: bookId)
          .get();

      if (querySnapshot.docs.isNotEmpty) {
        return querySnapshot.docs[0]['Image'];
      }
      return "null";
    } catch (e) {
      print('Error: $e');
      return "null";
    }
  }

  Future<String> author(int bookId) async {
    try {
      QuerySnapshot querySnapshot = await FirebaseFirestore.instance
          .collection('book')
          .where('bookId', isEqualTo: bookId)
          .get();

      if (querySnapshot.docs.isNotEmpty) {
        return querySnapshot.docs[0]['Author'];
      }
      return "null";
    } catch (e) {
      print('Error: $e');
      return "null";
    }
  }

  Future<List<dynamic>> getData(int bookId) async {
    List<Future<dynamic>> futures = [
      name(bookId),
      author(bookId),
      image(bookId),
    ];

    return await Future.wait(futures);
  }

  @override
  Widget build(BuildContext context) {
    final provider = Provider.of<FavouriteProvider>(context);
    return FutureBuilder(
        future: getData(book.bookId),
        builder: (BuildContext context, AsyncSnapshot snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return CircularProgressIndicator(); // or some loading indicator
          }
          return Container(
            width: 170.0,
            child: Row(
              children: [
                Column(
                  mainAxisAlignment: MainAxisAlignment.start,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Container(
                      width: 121.66,
                      height: 180.5,
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(8.0),
                          image: DecorationImage(
                            image: NetworkImage(snapshot.data[2]),
                            fit: BoxFit.cover,
                          )),
                    ),
                    Center(
                        child: Text(
                      snapshot.data[0],
                      style: TextStyle(
                          fontWeight: FontWeight.w900,
                          color: Color(0xffa0978d)),
                    )),
                    Center(
                        child: Text(
                      snapshot.data[1],
                      style: TextStyle(
                          fontWeight: FontWeight.w900,
                          color: Color(0xffa0978d)),
                    )),
                  ],
                ),
                IconButton(
                  onPressed: () {
                    toggleFavourite(book.bookId);
                  },
                  icon: FutureBuilder<bool>(
                    future: isExist(book.bookId),
                    builder:
                        (BuildContext context, AsyncSnapshot<bool> snapshot) {
                      if (snapshot.connectionState == ConnectionState.waiting) {
                        return CircularProgressIndicator();
                      } else if (snapshot.hasError) {
                        return Icon(Icons.error);
                      } else {
                        return Icon(
                          snapshot.data!
                              ? Icons.favorite
                              : Icons.favorite_border,
                          size: 35.0,
                          color: Color(0xffcf1a26),
                        );
                      }
                    },
                  ),
                ),
              ],
            ),
          );
        });
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
        context as BuildContext,
        MaterialPageRoute(builder: (context) => dashBoard1()),
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
        context as BuildContext,
        MaterialPageRoute(builder: (context) => dashBoard1()),
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
