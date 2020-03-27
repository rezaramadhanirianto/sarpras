import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'globals.dart' as globals;

class DetailReport extends StatefulWidget {
  DetailReport({Key key, this.id});
  final String id;
  @override
  _DetailReportState createState() => _DetailReportState();
}

class _DetailReportState extends State<DetailReport> {
  String item = "";
  String date = "";
  String claim = "";
  String claim_text = "";
  String reason = "";
  String img = "";
  String asssetimg = "";
  Future<List> getData() async {
    final response = await http.post("${globals.url}getonereport", body: {
      "id": widget.id,
    });
    var data = json.decode(response.body);
    setState(() {
      item = data['item'];
      date = data['date'];
      claim = data['claim'];
      claim_text = data['claim_text'];
      reason = data['reason'];
      img = data['img'];
      if (claim == "1") {
        asssetimg = "img/havent.png";
      } else if (claim == "2") {
        asssetimg = "img/check.png";
      } else {
        asssetimg = "img/silang.png";
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    getData();
    return Scaffold(
      backgroundColor: Color(0xFF7A9BEE),
        appBar: AppBar(
          leading: IconButton(
            onPressed: () {
              Navigator.of(context).pop();
            },
            icon: Icon(Icons.arrow_back_ios),
            color: Colors.white,
          ),
          backgroundColor: Colors.transparent,
          elevation: 0.0,
          title: Text('Detil Laporan',
              style: TextStyle(
                  fontFamily: 'Montserrat',
                  fontSize: 18.0,
                  color: Colors.white)),
          centerTitle: true,
        ),
      body: ListView(
          children: [
            Stack(children: [
              Container(
                  height: MediaQuery.of(context).size.height + 150,
                  width: MediaQuery.of(context).size.width,
                  color: Colors.transparent),
              Positioned(
                  top: 75.0,
                  child: Container(
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.only(
                            topLeft: Radius.circular(45.0),
                            topRight: Radius.circular(45.0),
                          ),
                          color: Colors.white),
                      height: MediaQuery.of(context).size.height,
                      width: MediaQuery.of(context).size.width)),
              Positioned(
                  top: 70.0,
                  left: (MediaQuery.of(context).size.width / 2) -  50,
                  child: Hero(
                      tag: img,
                      child: Container(
                          decoration: BoxDecoration(
                            
                              image: DecorationImage(
                                
                                  image: AssetImage(asssetimg),
                                  fit: BoxFit.cover)),
                          height: 100.0,
                          width: 100.0))),
              Positioned(
                  top: 200.0,
                  left: 25.0,
                  right: 25.0,
                  child: SingleChildScrollView(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: <Widget>[
                        Text(item,
                            style: TextStyle(
                                fontFamily: 'Montserrat',
                                fontSize: 22.0,
                                color: Colors.black,
                                fontWeight: FontWeight.bold)),
                        SizedBox(height: 20.0),
                        Row(
                          children: <Widget>[
                            Text(claim_text,
                                style: TextStyle(
                                    fontFamily: 'Montserrat',
                                    fontSize: 20.0,
                                    color: Colors.black38,)),
                                    
                            Padding(
                              padding: const EdgeInsets.only(left : 10.0, right: 20),
                              child: Container(
                                  height: 25.0, color: Colors.black38, width: 1.0),
                            ),
                            Text(date,
                            textAlign: TextAlign.end,
                                style: TextStyle(
                                    color: Colors.black38,
                                    fontFamily: 'Montserrat',
                                    fontSize: 15.0)),
                          ],
                        ),
                        SizedBox(height: 20.0),
                        Text("Gambar",
                            style: TextStyle(
                                fontFamily: 'Montserrat',
                                fontSize: 22.0,
                                fontWeight: FontWeight.bold)),
                        SizedBox(height: 20.0),
                        Center(
                          child: Container(
                              decoration: BoxDecoration(
                                  image: DecorationImage(
                                                    image: NetworkImage(
                                    '${globals.realUrl}/public/upload/$img',
                                  ),
                                      fit: BoxFit.cover)),
                              height: 200.0,
                              width: 200.0),
                        ),
                        SizedBox(height: 20.0),
                        Text("Alasan",
                            style: TextStyle(
                                fontFamily: 'Montserrat',
                                fontSize: 22.0,
                                color: Colors.black,
                                fontWeight: FontWeight.bold)),
                                SizedBox(height: 20.0),
                        Text(reason,
                            style: TextStyle(
                              color: Colors.black38,
                                fontFamily: 'Montserrat',
                                )),
                      ],
                    ),
                  )),
            ])
            ,
          ],
        )
        );
  }
}
