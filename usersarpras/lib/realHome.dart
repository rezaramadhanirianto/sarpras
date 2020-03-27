import 'dart:convert';
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:flutter/material.dart' as prefix0;
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'globals.dart' as globals;
import 'package:image_picker/image_picker.dart';
import 'package:async/async.dart';
import 'package:path/path.dart';

class RealHome extends StatefulWidget {
  @override
  _RealHomeState createState() => _RealHomeState();
}

class _RealHomeState extends State<RealHome> {
  File _image;
  String dropdownValue;
  var currentSelectedValue = "Baik";
  var deviceTypes = ["Baik", "Cukup", "Kurang"];

  @override
  void initState() {
    super.initState();
  }

  Future<List> _show() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    var id = prefs.getInt('id');
    String str = "${globals.url}show/$id";
    final response = await http.post(str, body: {});
    // print(json.decode(response.body));
    return json.decode(response.body);
  }

  Future<void> _onRefresh() async {
    await Future.delayed(Duration(milliseconds: 1000));
    setState(() {
      _show();
    });
  }

  void cek() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    var id = prefs.getInt('id');
  }

  @override
  Widget build(BuildContext context) {
    // cek();
    return Scaffold(
      body: prefix0.RefreshIndicator(
        onRefresh: _onRefresh,
        child: new FutureBuilder<List>(
          future: _show(),
          builder: (context, snapshot) {
            if (snapshot.hasError) print(snapshot.error);

            return snapshot.hasData
                ? new ListItem(
                    list: snapshot.data,
                  )
                : new Center(
                    child: new CircularProgressIndicator(),
                  );
          },
        ),
      ),
    );
  }
}

class ItemList extends StatelessWidget {
  var editBarangs = TextEditingController();
  var editJumlahs = TextEditingController();
  final List list;
  ItemList({this.list});
  File img;

  @override
  Widget build(BuildContext context) {
    return GridView.count(
      crossAxisCount: 2,
      shrinkWrap: true,
      children: List.generate(list.length, (i) {
        return new Container(
          child: new GestureDetector(
            onTap: () {},
            child: InkWell(
              child: new Card(
                child: Column(
                  children: <Widget>[
                    Image.network(
                      '${globals.realUrl}/public/upload/${list[i]["image"]}',
                    )
                  ],
                ),
              ),
              onTap: () {
                showDialog(
                    context: context,
                    builder: (BuildContext context) {
                      return AlertDialog(
                        title: new Center(
                          child: Text('Show Barang',
                              style: new TextStyle(
                                fontSize: 25,
                              )),
                        ),
                        content: Container(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: <Widget>[
                              Padding(
                                padding: const EdgeInsets.all(8.0),
                                child: new InkWell(
                                  child: Image.network(
                                    '${globals.realUrl}/public/upload/${list[i]['image']}',
                                  ),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Item : ${list[i]['item']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Total : ${list[i]['total']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Room : ${list[i]['room']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Status : ${list[i]['status']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Tipe : ${list[i]['tipe']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                            ],
                          ),
                        ),
                      );
                    });
              },
              // onDoubleTap: () {
              //   File img;
              //   img = null;
                
              //   void edit(a, b) {
              //       if(a == ""){
              //         editBarangs.text = "${list[i]['item']}";
              //       }else{
                      
              //       }
              //       if(b == ""){
              //         editJumlahs.text = "${list[i]['total']}";
              //       }else{

              //       }
              //   }

              //   void ubahItem(
              //       File imageFile, BuildContext context, int i) async {
              //     Navigator.pop(context);
              //     var uri = Uri.parse("${globals.url}edititem");
              //     var request = new http.MultipartRequest("POST", uri);

              //     if (img == null) {
              //       request.fields['img'] = "0";
              //     } else {
              //       request.fields['img'] = "1";
              //       var stream = new http.ByteStream(
              //           DelegatingStream.typed(imageFile.openRead()));
              //       var length = await imageFile.length();

              //       var multipartFile = new http.MultipartFile(
              //           "file", stream, length,
              //           filename: basename(imageFile.path));

              //       request.files.add(multipartFile);
              //     }

              //     request.fields['item'] = editBarangs.text;
              //     request.fields['id'] = i.toString();
              //     request.fields['total'] = editJumlahs.text;

              //     var response = await request.send();
              //     if (response.statusCode == 200) {
              //       print("Uploaded");
              //       print(response.toString());
              //     } else {
              //       print("Upload Failed");
              //     }
              //   }

              //   void show(a, b) {
                  
              //     showDialog(
              //         context: context,
              //         builder: (BuildContext context) {
              //           edit(a,b);
              //           return AlertDialog(
              //             title: new Center(
              //               child: Text('Edit Barang'),
              //             ),
              //             content: Container(
              //               child: SingleChildScrollView(
              //                 child: Column(
              //                   children: <Widget>[
              //                     TextField(
              //                       controller: editBarangs,
              //                       decoration: InputDecoration(
              //                         labelText: "Nama Barang",
              //                       ),
              //                     ),
              //                     TextField(
              //                       controller: editJumlahs,
              //                       decoration: InputDecoration(
              //                         labelText: "Jumlah",
              //                       ),
              //                     ),
              //                     Padding(
              //                       padding: const EdgeInsets.all(0),
              //                       child: InkWell(
              //                         child: img == null
              //                             ? Image.network(
              //                                 "${globals.realUrl}/public/upload/${list[i]['image']}",
              //                               )
              //                             : Image.file(
              //                                 img,
              //                               ),
              //                         onTap: () {
              //                           void getImage() async {
              //                             var imageFile =
              //                                 await ImagePicker.pickImage(
              //                                     source: ImageSource.gallery);
              //                             img = imageFile;

              //                             Navigator.pop(context);
              //                             show(editBarangs.text, editJumlahs.text);
              //                           }

              //                           getImage();
              //                           //   editBarangs.text = editBarangs.toString();
              //                           // editJumlahs.text = editBarangs.toString();
              //                           // print('asdf');
              //                         },
              //                       ),
              //                     ),
              //                     Padding(
              //                       padding: const EdgeInsets.only(top: 20.0),
              //                       child: FlatButton(
              //                         onPressed: () => {
              //                           ubahItem(img, context, list[i]['id'])
              //                         },
              //                         child: new Text(
              //                           "Simpan",
              //                           style: TextStyle(color: Colors.white),
              //                         ),
              //                         color: Color(0xFF7A9BEE),
              //                       ),
              //                     )
              //                   ],
              //                 ),
              //               ),
              //             ),
              //           );
              //         });
              //   }

              //   show("", "");
              // },
            ),
          ),
        );
      }),
    );
  }
}
 
class ListItem extends StatelessWidget {
  var editBarangs = TextEditingController();
  var editJumlahs = TextEditingController();
  final List list;
  ListItem({this.list});
  File img;
  @override
  Widget build(BuildContext context) {
    return new ListView.builder(
      itemCount: list == null ? 0 : list.length,
      itemBuilder: (context, i) {
        return new Container(
          padding: const EdgeInsets.all(10.0),
          child: new GestureDetector(
            onTap: () {
                showDialog(
                    context: context,
                    builder: (BuildContext context) {
                      return AlertDialog(
                        title: new Center(
                          child: Text('Show Barang',
                              style: new TextStyle(
                                fontSize: 25,
                              )),
                        ),
                        content: Container(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: <Widget>[
                              Padding(
                                padding: const EdgeInsets.all(8.0),
                                child: new InkWell(
                                  child: Image.network(
                                    '${globals.realUrl}/public/upload/${list[i]['image']}',
                                  ),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Item : ${list[i]['item']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Total : ${list[i]['total']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Room : ${list[i]['room']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Status : ${list[i]['status']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                              Padding(
                                padding: const EdgeInsets.all(5.0),
                                child: new Text(
                                  "Tipe : ${list[i]['tipe']}",
                                  style: new TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.w400),
                                ),
                              ),
                            ],
                          ),
                        ),
                      );
                    });
              },
            child: new Card(
              child: new ListTile(
                title: new Text(list[i]['item'], maxLines: 1, overflow: TextOverflow.ellipsis,),
                leading: InkWell(
                  child: Image.network(
                  '${globals.realUrl}/public/upload/${list[i]['image']}',
                  ),
                ),
                subtitle: new Text("Ruangan : ${list[i]['room']}"),
              ),
            ),
          ),
        );
      },
    );
  }
  }