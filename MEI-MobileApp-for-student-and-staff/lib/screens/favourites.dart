import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:provider/provider.dart';

import '../components/NavBar.dart';
import '../provider/favourite_provider.dart';

class Favourites extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _favouriteState();
  }
}

class _favouriteState extends State<Favourites> {
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();

  @override
  Widget build(BuildContext context) {
    final provider = Provider.of<FavouriteProvider>(context);
    final books = provider.books;
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
                Center(
                    child: Text(
                  "Favourites",
                  style: TextStyle(
                      color: Color(0xffcf1a26),
                      fontWeight: FontWeight.w900,
                      fontSize: 35.0),
                )),
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
                                      Container(
                                        width: 121.66,
                                        height: 180.5,
                                        decoration: BoxDecoration(
                                            borderRadius:
                                                BorderRadius.circular(8.0),
                                            image: DecorationImage(
                                              image:
                                                  NetworkImage(book.bookCover),
                                              fit: BoxFit.cover,
                                            )),
                                      ),
                                      RatingBarIndicator(
                                        itemBuilder: (context, index) => Icon(
                                          Icons.star,
                                          color: Color(0xffcf1a26),
                                        ),
                                        rating: 2.75,
                                        itemCount: 5,
                                        itemSize: 23.0,
                                        direction: Axis.horizontal,
                                      ),
                                    ],
                                  ),
                                  Column(
                                    mainAxisAlignment:
                                        MainAxisAlignment.spaceEvenly,
                                    children: [
                                      Column(
                                        children: [
                                          Text(
                                            book.bookName,
                                            style: TextStyle(
                                                fontWeight: FontWeight.w900,
                                                color: Color(0xffa0978d)),
                                          ),
                                          Text(
                                            book.author,
                                            style: TextStyle(
                                                fontWeight: FontWeight.w900,
                                                color: Color(0xffa0978d)),
                                          ),
                                        ],
                                      ),
                                      IconButton(
                                          onPressed: () {
                                            provider.toggleFavourite(book);
                                          },
                                          icon: provider.isExists(book)
                                              ? const Icon(
                                                  Icons.favorite,
                                                  size: 35.0,
                                                  color: Color(0xffcf1a26),
                                                )
                                              : const Icon(
                                                  Icons.favorite_border,
                                                  size: 35.0,
                                                  color: Color(0xffcf1a26),
                                                ))
                                    ],
                                  )
                                ],
                              ),
                              SizedBox(
                                height: 10.0,
                              )
                            ],
                          );
                        })),
              ],
            ),
          )))
        ],
      )),
    );
  }
}
