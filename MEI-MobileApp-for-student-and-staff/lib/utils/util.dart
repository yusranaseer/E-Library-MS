import 'dart:io';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/services.dart';
import 'package:flutter_session_manager/flutter_session_manager.dart';
import 'package:pdf/widgets.dart' as pw;
import 'package:flutter/material.dart';
import 'package:open_file/open_file.dart';
import 'package:path_provider/path_provider.dart';
import 'package:pdf/pdf.dart';
import 'package:printing/printing.dart';
import 'package:intl/intl.dart';
import 'dart:math';

Future<Uint8List> generatePdf(final PdfPageFormat format) async {
  final doc = pw.Document(
    title: 'Mec Scool',
  );
  final logoImage = pw.MemoryImage(
    (await rootBundle.load('assests/images/MEC_PNG _new.png'))
        .buffer
        .asUint8List(),
  );

  final badge = pw.MemoryImage(
    (await rootBundle.load('assests/images/badge.png')).buffer.asUint8List(),
  );
  final font1 = await rootBundle.load('assests/fonts/BlackMango-Regular.ttf');
  final ttf1 = pw.Font.ttf(font1);
  final font2 = await rootBundle.load('assests/fonts/Open_Sans_Regular.ttf');
  final ttf2 = pw.Font.ttf(font2);

  DateTime submittedDate = DateTime.now();
  String formattedDate = DateFormat('yyyy-MM-dd').format(submittedDate);

  int currentYear = DateTime.now().year;

  Random random = Random();
  int num1 = random.nextInt(10000);
  int num2 = random.nextInt(10000);

  dynamic id = await SessionManager().get("user");
  int userId = id;

  await Firebase.initializeApp();

  QuerySnapshot taskSnapshot = await FirebaseFirestore.instance
      .collection('student')
      .where('UID', isEqualTo: userId)
      .limit(1)
      .get();

  String fname = taskSnapshot.docs[0]['First_Name'];
  String lname = taskSnapshot.docs[0]['Last_Name'];
  String name = "$fname $lname";

  final pageTheme = await _myPageTheme(format);
  doc.addPage(pw.MultiPage(
      pageTheme: pageTheme,
      footer: (final context) => pw.Text('ISSUED ON $formattedDate',
          style: pw.TextStyle(
              fontWeight: pw.FontWeight.bold,
              fontSize: 10,
              color: PdfColor.fromInt(0xffcf1a26))),
      build: (final context) => [
            pw.Container(
                width: double.infinity,
                child: pw.Column(children: [
                  pw.Row(
                      mainAxisAlignment: pw.MainAxisAlignment.end,
                      children: [
                        pw.Column(children: [
                          pw.Text('CERTIFICATE NUMBER:MEC/SA/$num1/$num2',
                              style: pw.TextStyle(
                                  fontWeight: pw.FontWeight.bold,
                                  color: PdfColor.fromInt(0xffcf1a26))),
                          pw.Image(
                            logoImage,
                            width: 180,
                          )
                        ]),
                      ]),
                  pw.Column(
                      crossAxisAlignment: pw.CrossAxisAlignment.center,
                      children: [
                        pw.Text('Certificate',
                            style: pw.TextStyle(
                                font: ttf1,
                                fontWeight: pw.FontWeight.bold,
                                fontSize: 50)),
                        pw.Row(
                            mainAxisAlignment:
                                pw.MainAxisAlignment.spaceBetween,
                            children: [
                              pw.Expanded(
                                child: pw.Divider(
                                    color: PdfColor.fromInt(0xffddc985),
                                    indent: 30,
                                    endIndent: 10,
                                    thickness: 5),
                              ),
                              pw.Text('OF PERFORMANCE',
                                  style: pw.TextStyle(
                                      font: ttf2,
                                      fontWeight: pw.FontWeight.bold,
                                      fontSize: 18.2)),
                              pw.Expanded(
                                child: pw.Divider(
                                    color: PdfColor.fromInt(0xffddc985),
                                    endIndent: 40,
                                    indent: 10,
                                    thickness: 5),
                              ),
                            ]),
                        pw.SizedBox(height: 10),
                        pw.Text('THIS CERTIFICATE IS AWARDED TO',
                            style: pw.TextStyle()),
                        pw.SizedBox(height: 10),
                        pw.Text('$name', style: pw.TextStyle()),
                        pw.Divider(
                            color: PdfColor.fromInt(0xffddc985),
                            endIndent: 100,
                            indent: 100,
                            thickness: 5),
                        pw.SizedBox(height: 10),
                        pw.Container(
                          margin: pw.EdgeInsets.only(left: 50, right: 90),
                          child: pw.Text(
                              'FOR EXCELLENT PERFORMANCE IN E-LIBRARY ACHIEVEMENT DURING THE ACADEMIC YEAR OF $currentYear',
                              textAlign: pw.TextAlign.center,
                              style: pw.TextStyle()),
                        ),
                        pw.SizedBox(height: 10),
                        pw.Image(badge, width: 90, height: 80),
                        pw.SizedBox(height: 10),
                        pw.Container(
                            margin: pw.EdgeInsets.only(right: 110),
                            child: pw.Row(
                                mainAxisAlignment:
                                    pw.MainAxisAlignment.spaceEvenly,
                                children: [
                                  pw.Expanded(
                                    child: pw.Column(children: [
                                      pw.SizedBox(height: 15),
                                      pw.Image(badge, width: 100, height: 80),
                                      pw.Divider(
                                          color: PdfColor.fromInt(0xffddc985),
                                          endIndent: 10,
                                          thickness: 2),
                                      pw.Text('HEAD-STUDENT AFFAIRS',
                                          maxLines: 2,
                                          style: pw.TextStyle(
                                            fontWeight: pw.FontWeight.bold,
                                          )),
                                    ]),
                                  ),
                                  pw.Expanded(
                                    child: pw.Column(children: [
                                      pw.Image(badge, width: 100, height: 80),
                                      pw.Divider(
                                          color: PdfColor.fromInt(0xffddc985),
                                          endIndent: 10,
                                          thickness: 2),
                                      pw.Text('DIRECTOR',
                                          maxLines: 2,
                                          style: pw.TextStyle(
                                            fontWeight: pw.FontWeight.bold,
                                          )),
                                    ]),
                                  ),
                                  pw.Expanded(
                                      child: pw.Column(children: [
                                    pw.Image(badge, width: 100, height: 80),
                                    pw.Divider(
                                        color: PdfColor.fromInt(0xffddc985),
                                        thickness: 2),
                                    pw.Text('PRINCIPAL',
                                        maxLines: 2,
                                        style: pw.TextStyle(
                                          fontWeight: pw.FontWeight.bold,
                                        )),
                                  ])),
                                ])),
                      ]),
                ]))
          ]));
  return doc.save();
}

Future<pw.PageTheme> _myPageTheme(PdfPageFormat format) async {
  final fullImage = pw.MemoryImage(
    (await rootBundle.load('assests/images/Certificate.png'))
        .buffer
        .asUint8List(),
  );
  return pw.PageTheme(
      margin: pw.EdgeInsets.symmetric(
          horizontal: 1 * PdfPageFormat.cm, vertical: 0.2 * PdfPageFormat.cm),
      textDirection: pw.TextDirection.ltr,
      orientation: pw.PageOrientation.portrait,
      buildBackground: (final context) => pw.FullPage(
          ignoreMargins: true,
          child: pw.Watermark(
              child: pw.Opacity(
                  opacity: 1.0,
                  child: pw.Image(fullImage, fit: pw.BoxFit.cover)))));
}

Future<void> saveAsFile(
  final BuildContext context,
  final LayoutCallback build,
  final PdfPageFormat pageFormat,
) async {
  final bytes = await build(pageFormat);

  final appDocDir = await getApplicationDocumentsDirectory();
  final appDocPath = appDocDir.path;
  final file = File('$appDocPath/document.pdf');
  print('save as file ${file.path}...');
  await file.writeAsBytes(bytes);
  await OpenFile.open(file.path);
}

void showPrintedToast(final BuildContext context) {
  ScaffoldMessenger.of(context)
      .showSnackBar(SnackBar(content: Text('Document Printed Successfully')));
}

void showSharedToast(final BuildContext context) {
  ScaffoldMessenger.of(context)
      .showSnackBar(SnackBar(content: Text('Document shared Successfully')));
}
