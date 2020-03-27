import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:http/http.dart' as http;
import 'package:progress_dialog/progress_dialog.dart';
import 'package:sarpras/home.dart';
import 'package:sarpras/report.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'globals.dart' as globals;
import 'package:path/path.dart';
import 'package:async/async.dart';

class FormReport extends StatefulWidget {
  final int id;
  final String item;
  FormReport({this.id, this.item});
  @override
  _FormReportState createState() => _FormReportState();
}

class _FormReportState extends State<FormReport> {
  File img;
  TextEditingController alasanTextEditing;
  TextEditingController totalTextEditing;
  ProgressDialog pr;

  @override
  void initState() {
    super.initState();
    alasanTextEditing = new TextEditingController(text: '');
    totalTextEditing = new TextEditingController(text: '');
  }

  void getImage() async {
    var imageFile = await ImagePicker.pickImage(source: ImageSource.gallery);
    setState(() {
      img = imageFile;
    });
  }

  void addReport(File imageFile, BuildContext context) async {
    if (imageFile == null ||
        totalTextEditing.text == "" ||
        alasanTextEditing.text == "") {
      showDialog(
          context: context,
          builder: (BuildContext context) {
            // return object of type Dialog
            return AlertDialog(
              title: new Text("Gagal"),
              content: new Text("Silahkan Isi semua inputan"),
              actions: <Widget>[
                // usually buttons at the bottom of the dialog
                new FlatButton(
                  child: new Text("Close"),
                  onPressed: () {
                    Navigator.of(context).pop();
                  },
                ),
              ],
            );
          });
    } else {
      pr = new ProgressDialog(context, type: ProgressDialogType.Normal);
      pr.style(
        message: 'Mengirim ...',
        borderRadius: 10.0,
        backgroundColor: Colors.white,
        progressWidget: CircularProgressIndicator(),
      );
      pr.show();
      SharedPreferences prefs = await SharedPreferences.getInstance();
      var id = prefs.getInt('id');

      var uri = Uri.parse("${globals.url}addreport");

      var request = new http.MultipartRequest("POST", uri);
      var stream =
          new http.ByteStream(DelegatingStream.typed(imageFile.openRead()));
      var length = await imageFile.length();
      var multipartFile = new http.MultipartFile("file", stream, length,
          filename: basename(imageFile.path));

      request.files.add(multipartFile);

      request.fields['id_item'] = "${widget.id}";
      request.fields['id'] = id.toString();
      request.fields['total'] = totalTextEditing.text;
      request.fields['reason'] = alasanTextEditing.text;
      var response = await request.send();

      if (response.statusCode == 200) {
        pr.hide();
        print("Uploaded");
        Navigator.push(
            context, MaterialPageRoute(builder: (BuildContext) => Home()));
      } else {
        pr.hide();
        showDialog(
            context: context,
            builder: (BuildContext context) {
              // return object of type Dialog
              return AlertDialog(
                title: new Text("Gagal"),
                content: new Text("Silahkan Isi semua inputan"),
                actions: <Widget>[
                  // usually buttons at the bottom of the dialog
                  new FlatButton(
                    child: new Text("Close"),
                    onPressed: () {
                      Navigator.of(context).pop();
                    },
                  ),
                ],
              );
            });
        print("Upload Failed");
        print("${globals.url}additem");
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomPadding: false,
      appBar: AppBar(
        title: new Text("Form Report"),
        backgroundColor: Colors.orange[300],
      ),
      body: ListView(
        children: <Widget>[
          Padding(
            padding: const EdgeInsets.all(8.0),
            child: Container(
              child: Column(
                children: <Widget>[
                  Padding(
                    padding: const EdgeInsets.only(top: 20.0),
                    child: Center(
                      child: Text(
                        "Form Report",
                        style: TextStyle(
                            fontSize: 40, fontFamily: "DancingScript"),
                      ),
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(8.0),
                    child: Center(
                      child: InkWell(
                        onTap: () {
                          getImage();
                        },
                        child: Container(
                          width: MediaQuery.of(context).size.width / 2,
                          height: MediaQuery.of(context).size.width / 2,
                          decoration: BoxDecoration(
                              shape: BoxShape.circle,
                              image: new DecorationImage(
                                  fit: BoxFit.cover,
                                  image: img == null
                                      ? AssetImage("img/newreport.png")
                                      : FileImage(img))),
                        ),
                      ),
                    ),
                  ),
                  Text("Nama Barang : ${widget.item}"),
                  TextField(
                    keyboardType: TextInputType.number,
                    controller: totalTextEditing,
                    decoration: InputDecoration(
                      icon: Icon(Icons.add),
                      labelText: "Jumlah",
                    ),
                  ),
                  TextField(
                    controller: alasanTextEditing,
                    maxLines: 3,
                    decoration: InputDecoration(
                      icon: Icon(Icons.comment),
                      labelText: "Keterangan",
                    ),
                  ),
                  FlatButton(
                    color: Colors.orange,
                    onPressed: () {
                      addReport(img, context);
                    },
                    child: Text("Tambah Laporan"),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
