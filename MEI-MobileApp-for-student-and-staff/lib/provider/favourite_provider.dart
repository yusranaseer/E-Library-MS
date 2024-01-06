import 'package:flutter/material.dart';

import '../data/bookData.dart';

class FavouriteProvider extends ChangeNotifier {
  final List<BookData> _books = [];

  List<BookData> get books => _books;

  void toggleFavourite(BookData book) {
    final isExist = _books.contains(book);
    if (isExist) {
      _books.remove(book);
    } else {
      _books.add(book);
    }
    notifyListeners();
  }

  bool isExists(BookData book) {
    final isExist = _books.contains(book);
    return isExist;
  }
}
