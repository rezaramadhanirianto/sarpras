import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:http/http.dart' as http;
import 'globals.dart' as globals;

class Barcode extends StatefulWidget {
  @override
  _BarcodeState createState() => _BarcodeState();
}

class _BarcodeState extends State<Barcode> {
  String code = "";
  String getcode = "";
  String name ="";
  String room ="";
  String status ="";
  String total ="";
  String img ="";

  Future scanbarcode() async {
    getcode = await FlutterBarcodeScanner.scanBarcode("#009922", "Cancel", true);
    final response = await http.post("${globals.url}getitem/$getcode", body: {});
    var data = json.decode(response.body);
    setState(() {
       name = data['item'];
       room = data['room'];
       status = data['status'];
       total = data['total'].toString();
       img = data['image'];
    });

  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        
        child: Padding(
          padding: const EdgeInsets.all(5.0),
          child: ListView(
            children: <Widget>[
              Row(
                children: <Widget>[
                  InkWell(
                    onTap: () {},
                    child: Image.asset(
                      'img/barcode.png',
                      width: 200,
                      height: 200,
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.only(left: 0),
                    child: Column(
                      children: <Widget>[
                        new Text(
                          "Barcode",
                          style: new TextStyle(fontSize: 45, fontFamily: "DancingScript"),
                        ),
                        new Text("Scan your barcode !", style: new TextStyle(),)
                      ],
                    ),
                  ),
                ],
              ),
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  children: <Widget>[
                    Card(
                        color: Colors.orange[300],
                        child: 
                        SizedBox(
                          width: double.infinity,
                          child: Column(
                            children: <Widget>[
                              FlatButton(
                                onPressed: () {
                                  scanbarcode();
                                },
                                color: Color(0xFF7A9BEE),
                                child: new Text("Scan Barcode", style: TextStyle(color: Colors.white),),
                              ),
                                new Text("Nama Barang : $name", style: new TextStyle(fontSize: 20, fontWeight: FontWeight.w300),),
                                new Text("Ruangan : $room", style: new TextStyle(fontSize: 20, fontWeight: FontWeight.w300),),
                                new Text("Status : $status", style: new TextStyle(fontSize: 20, fontWeight: FontWeight.w300),),
                                new Text("Jumlah : $total", style: new TextStyle(fontSize: 20, fontWeight: FontWeight.w300),),
                                new InkWell(
                                  child: Image.network(
                                    '${globals.realUrl}public/upload/$img',
                                    width: 200,
                                    height: 200,
                                  ),
                                ),
                            ],
                          ),
                        )
                        )
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
