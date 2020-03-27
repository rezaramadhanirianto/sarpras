import 'package:flutter/material.dart';
import 'package:sarpras/barcodeReport.dart';
import 'package:sarpras/formReport.dart';
import 'package:sarpras/listReport.dart';

class Report extends StatefulWidget {
  @override
  _ReportState createState() => _ReportState();
}

class _ReportState extends State<Report> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color.fromRGBO(220, 220, 223, 1),
      body: Padding(
        padding: const EdgeInsets.all(0),
        child: ListView(
          children: <Widget>[
            Row(
              children: <Widget>[
                Container(
                  width: MediaQuery.of(context).size.width,
                  height: MediaQuery.of(context).size.height / 2,
                  decoration: BoxDecoration(
                    image: DecorationImage(
                      fit: BoxFit.fill,
                      image: AssetImage("img/newreport.png"),
                    ),
                  ),
                )
                // Padding(
                //   padding: const EdgeInsets.only(left: 0.0),
                //   child: Column(
                //     children: <Widget>[
                //       new Text(
                //         "Report",
                //         style: new TextStyle(
                //             fontSize: 55, fontFamily: "DancingScript"),
                //       ),
                //       Text("You have a report ?")
                //     ],
                //   ),
                // ),
              ],
            ),
            Container(
                // decoration: new BoxDecoration(
                //   color: Colors.orange[300],
                //   borderRadius: new BorderRadius.only(
                //     topLeft: const Radius.circular(100.0),
                //   ),
                // ),
                child: new Center(
                  child: Column(
                    children: <Widget>[
                      new Text("You Have A Report ? ", style: TextStyle(fontSize: 30, fontFamily: "DancingScript"),),
                      Padding(
                        padding: const EdgeInsets.all(15.0),
                        child: new FlatButton(
                          onPressed: (){
                            Navigator.push(context, 
                                MaterialPageRoute(
                                  builder: (BuildContext context) => BarcodeReport()
                                )
                              );
                          },
                          child: Text("CLICK HERE ", style: new TextStyle(color: Colors.white, fontFamily: "Vibes", fontSize: 25.0),),
                          color: Color(0xFF7A9BEE),
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.all(15.0),
                        child: new FlatButton(
                          onPressed: (){
                            Navigator.push(context, 
                                MaterialPageRoute(
                                  builder: (BuildContext context) => ListReport()
                                )
                              );
                          },
                          child: Text("Show Report List ", style: new TextStyle(color: Colors.white, fontFamily: "Vibes", fontSize: 25.0),),
                          color: Color(0xFF7A9BEE),
                        ),
                      ),

                    ],
                  ),
                )),
          ],
        ),
      ),
    );
  }
}
