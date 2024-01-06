import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:phone_form_field/phone_form_field.dart';

class phoneFormFieldProfile extends StatelessWidget {
  final String title;
  final IconData icon;
  final PhoneController phonectrl;
  final VoidCallback onTapCallback;

  phoneFormFieldProfile(
      this.title, this.icon, this.phonectrl, this.onTapCallback);

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          title,
          style: GoogleFonts.poppins(
            fontSize: 14.0,
            fontWeight: FontWeight.w600,
          ),
        ),
        SizedBox(
          height: 6.0,
        ),
        Container(
          decoration: BoxDecoration(
            color: Colors.white,
            boxShadow: [
              BoxShadow(
                color: Color(0xffcf1a26),
                spreadRadius: 1,
                blurRadius: 1,
              ),
            ],
            borderRadius: BorderRadius.circular(8),
          ),
          child: InkWell(
            onTap: onTapCallback, // Call the onTapCallback when tapped
            child: PhoneFormField(
              controller: phonectrl,
              defaultCountry: IsoCode.LK,
              style: GoogleFonts.poppins(
                fontSize: 20.0,
                fontWeight: FontWeight.w600,
                color: Color(0xffA7A7A7),
              ),
              decoration: InputDecoration(
                prefixIcon: Padding(
                  padding: const EdgeInsets.only(left: 10),
                  child: Icon(
                    icon,
                    color: Color(0xffcf1a26),
                    size: 40.0,
                  ),
                ),
                border: InputBorder.none,
              ),
            ),
          ),
        ),
      ],
    );
  }
}
