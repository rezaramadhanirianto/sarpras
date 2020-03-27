import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:http/http.dart' as http;
import 'package:sarpras/formReport.dart';
import 'globals.dart' as globals;

class BarcodeReport extends StatefulWidget {
  @override
  _BarcodeReportState createState() => _BarcodeReportState();
}

class _BarcodeReportState extends State<BarcodeReport> {
  String getcode = "";
  int id = 0;
  String item = "";

  Future scanbarcode() async {
    getcode =
        await FlutterBarcodeScanner.scanBarcode("#009922", "Cancel", true);

    final response =
        await http.post("${globals.url}getitem/$getcode", body: {});
    var data = json.decode(response.body);

    setState(() {
      id = data['id'];
      item = data["item"];
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Scan Barcode"),
        backgroundColor: Color(0xFF7A9BEE),
      ),
      body: Container(
        color: Colors.orange[200],
        child: Center(child: 
        Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: 
          [
            Padding(
              padding: const EdgeInsets.all(20),
              child: FlatButton(
                color: Color(0xFF7A9BEE),
                onPressed: () {
                  scanbarcode();
                  if (id == 0) {
                    // showDialog(
                    //   context: context,  
                    //   builder: Container(

                    //   ),
                    // );
                  } else {
                    Navigator.push(
                        context,
                        MaterialPageRoute(
                            builder: (BuildContext context) => FormReport(
                                  id: id,
                                  item: item,
                                )));
                  }
                },
                child: Center(
                  child: new Text("Scan Barcode", style: TextStyle(color: Colors.white),),
                ),
              ),
            ),
          ]
        ),)
      ),
    );
  }
}
