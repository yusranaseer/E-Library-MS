import 'package:carousel_slider/carousel_slider.dart';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:elibrary_frontend/components/headerwithNavbar.dart';
import 'package:elibrary_frontend/components/whiteCurvedBox.dart';
import 'package:elibrary_frontend/screens/About.dart';
import 'package:elibrary_frontend/components/NavBar.dart';
import 'package:elibrary_frontend/screens/Newspapers.dart';
import 'package:elibrary_frontend/screens/RewardsScreen.dart';
import 'package:elibrary_frontend/screens/booksScreen.dart';
import 'package:elibrary_frontend/screens/innovationScreen.dart';
import 'package:elibrary_frontend/screens/pastPapers.dart';
import 'package:elibrary_frontend/screens/practicles.dart';
import 'package:elibrary_frontend/screens/taskDisplay.dart';
import 'package:elibrary_frontend/screens/taskViewStaffFirst.dart';
import 'package:elibrary_frontend/widgets/Books.dart';
import 'package:elibrary_frontend/widgets/dashboard_Buttons.dart';
import 'package:flutter/material.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:provider/provider.dart';

import '../data/bookData.dart';
import '../provider/favourite_provider.dart';

class dashBoard1 extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _dashBoard1State();
  }
}

class _dashBoard1State extends State<dashBoard1> {
  dynamic type = '';

  @override
  void initState() {
    super.initState();
    checkType(); // Fetch the task data when the widget is initialized
  }

  void checkType() async {
    type = await SessionManager().get("usertype");
    print(type);
  }

  // List<BookData> books = [
  //   BookData(
  //       'https://bukovero.com/wp-content/uploads/2016/07/Harry_Potter_and_the_Cursed_Child_Special_Rehearsal_Edition_Book_Cover.jpg',
  //       'Memory',
  //       'ABC',
  //       'BLABLABLA',
  //       25,
  //       6.0),
  //   BookData('https://template.canva.com/EADaopxBna4/1/0/251w-ujD6UPGa9hw.jpg',
  //       'Memory', 'ABC', 'BLABLABLA', 25, 6.0),
  //   BookData(
  //       "https://notionpress.com/images/newdesign/Okka-Bokka_eBook-cover.png",
  //       'Memory',
  //       'ABC',
  //       'BLABLABLA',
  //       25,
  //       6.0),
  //   BookData(
  //       'https://s26162.pcdn.co/wp-content/uploads/2020/01/Sin-Eater-by-Megan-Campisi.jpg',
  //       'Memory',
  //       'ABC',
  //       'BLABLABLA',
  //       25,
  //       6.0)
  // ];
  List imageList = [
    {"id": 1, "image_path": 'assests/images/mercy.jpg'},
    {"id": 2, "image_path": 'assests/images/mercy2.jpg'},
  ];
  GlobalKey<ScaffoldState> _scaffoldkey = GlobalKey<ScaffoldState>();
  final CarouselController caroselcontroller = CarouselController();
  int currentIndex = 0;
  dynamic id = SessionManager().get("user");

  @override
  Widget build(BuildContext context) {
    final provider = Provider.of<FavouriteProvider>(context);
    return StreamBuilder<QuerySnapshot>(
        stream: FirebaseFirestore.instance
            .collection('fav')
            .where('UID', isEqualTo: id)
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
            return BookID(
              bookData['BID'],
            );
          }).toList();
          //final books = provider.books;
          return Scaffold(
            key: _scaffoldkey,
            endDrawer: SafeArea(child: NavBar()),
            backgroundColor: Color(0xffd9d9d9),
            body: SafeArea(
              child: Column(children: [
                headerWithNavbar(_scaffoldkey),
                Expanded(
                    child: whiteCurvedBox(
                  Padding(
                    padding: EdgeInsets.all(15.0),
                    child: Column(
                      children: [
                        Stack(
                          children: [
                            InkWell(
                              onTap: () {
                                print(currentIndex);
                              },
                              child: CarouselSlider(
                                items: imageList
                                    .map((item) => Image.asset(
                                          item['image_path'],
                                          fit: BoxFit.cover,
                                          width: double.infinity,
                                        ))
                                    .toList(),
                                carouselController: caroselcontroller,
                                options: CarouselOptions(
                                    scrollPhysics:
                                        const BouncingScrollPhysics(),
                                    autoPlay: true,
                                    aspectRatio: 2,
                                    viewportFraction: 1,
                                    onPageChanged: (index, reason) {
                                      setState(() {
                                        currentIndex = index;
                                      });
                                    }),
                              ),
                            )
                          ],
                        ),
                        SizedBox(
                          height: 15.0,
                        ),
                        if (type == "student")
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                            children: [
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Books',
                                size: 50.0,
                                icon: Icons.import_contacts,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return booksScreen();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Tasks',
                                size: 50.0,
                                icon: Icons.task,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return taskDisplay();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Past Papers',
                                size: 50.0,
                                icon: Icons.folder_open,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return pastPapers();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Practicals',
                                size: 50.0,
                                icon: Icons.biotech,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return practiclesScreen();
                                  }));
                                },
                              ),
                            ],
                          ),
                        if (type == 'staff')
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                            children: [
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Books',
                                size: 50.0,
                                icon: Icons.import_contacts,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return booksScreen();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Tasks',
                                size: 50.0,
                                icon: Icons.task,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return taskViewStaffFirst();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Past Papers',
                                size: 50.0,
                                icon: Icons.folder_open,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return pastPapers();
                                  }));
                                },
                              ),
                            ],
                          ),
                        SizedBox(
                          height: 15.0,
                        ),
                        if (type == "student")
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                            children: [
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Innovation',
                                size: 50.0,
                                icon: Icons.emoji_objects,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return innovationScreen();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Rewards',
                                size: 50.0,
                                icon: Icons.payments,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return RewardsScreen();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'News Papers',
                                size: 50.0,
                                icon: Icons.newspaper,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return newspapers();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'About Us',
                                size: 50.0,
                                icon: Icons.group,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return AboutUs();
                                  }));
                                },
                              ),
                              // dashButtons(
                              //   backgroundcolor: Color(0xffe5e5e5),
                              //   iconcolor: Color(0xffcf1a26),
                              //   text: 'Favourites',
                              //   size: 50.0,
                              //   icon: Icons.group,
                              //   bordercolor: Colors.white,
                              //   textcolor: Color(0xffd0cbc6),
                              //   callback: () {
                              //     Navigator.push(context,
                              //         MaterialPageRoute(builder: (context) {
                              //       return Favourites();
                              //     }));
                              //   },
                              // ),
                            ],
                          ),
                        if (type == 'staff')
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                            children: [
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'Practicals',
                                size: 50.0,
                                icon: Icons.biotech,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return practiclesScreen();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'News Papers',
                                size: 50.0,
                                icon: Icons.newspaper,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return newspapers();
                                  }));
                                },
                              ),
                              dashButtons(
                                backgroundcolor: Color(0xffe5e5e5),
                                iconcolor: Color(0xffcf1a26),
                                text: 'About Us',
                                size: 50.0,
                                icon: Icons.group,
                                bordercolor: Colors.white,
                                textcolor: Color(0xffd0cbc6),
                                callback: () {
                                  Navigator.push(context,
                                      MaterialPageRoute(builder: (context) {
                                    return AboutUs();
                                  }));
                                },
                              ),
                              // dashButtons(
                              //   backgroundcolor: Color(0xffe5e5e5),
                              //   iconcolor: Color(0xffcf1a26),
                              //   text: 'Favourites',
                              //   size: 50.0,
                              //   icon: Icons.group,
                              //   bordercolor: Colors.white,
                              //   textcolor: Color(0xffd0cbc6),
                              //   callback: () {
                              //     Navigator.push(context,
                              //         MaterialPageRoute(builder: (context) {
                              //       return Favourites();
                              //     }));
                              //   },
                              // ),
                            ],
                          ),
                        SizedBox(
                          height: 10.0,
                        ),
                        Align(
                          alignment: Alignment.centerLeft,
                          child: Text(
                            'Favourites',
                            style: TextStyle(
                                fontSize: 25.0, fontWeight: FontWeight.w900),
                          ),
                        ),
                        SizedBox(
                          height: 5.0,
                        ),
                        Expanded(
                          child: Container(
                            width: double.infinity,
                            child: ListView.builder(
                              itemCount: books.length,
                              scrollDirection: Axis.horizontal,
                              itemBuilder: (BuildContext context, int index) {
                                final book = books[index];
                                return Book(book);
                              },
                            ),
                          ),
                        )
                      ],
                    ),
                  ),
                ))
              ]),
            ),
          );
        });
  }
}
