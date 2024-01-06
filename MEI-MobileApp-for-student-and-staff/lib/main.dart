import 'package:elibrary_frontend/provider/favourite_provider.dart';
import 'package:elibrary_frontend/screens/loginScreen.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:firebase_core/firebase_core.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp();
  runApp(Myapp());
}

class Myapp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (context) {
        return FavouriteProvider();
      },
      child: MaterialApp(
        home: loginScreen(),
      ),
    );
  }
}
