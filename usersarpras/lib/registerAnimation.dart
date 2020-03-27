import 'dart:convert';

import 'package:flutter/material.dart';
import 'main.dart';
import 'package:http/http.dart' as http;
import 'globals.dart' as globals;
import 'package:fancy_dialog/fancy_dialog.dart';

class RegisterAnimation extends StatefulWidget {
  RegisterAnimation(
      {Key key,
      this.buttonController,
      this.nama,
      this.email,
      this.room,
      this.cpass,
      this.pass})
      : shrinkButtonAnimation = new Tween(begin: 320.0, end: 70.0).animate(
          CurvedAnimation(
              parent: buttonController, curve: Interval(0.0, 0.150)),
        ),
        zoomAnimation =
            new Tween(begin: 70.0, end: 900.0).animate(CurvedAnimation(
                parent: buttonController,
                curve: Interval(
                  0.550,
                  0.999,
                  curve: Curves.bounceInOut,
                ))),
        super(key: key);

  final AnimationController buttonController;
  final Animation shrinkButtonAnimation;
  final Animation zoomAnimation;
  final String nama;
  final String email;
  final String room;
  final String pass;
  final String cpass;

  Widget _buildAnimation(BuildContext context, Widget child) {
    return Padding(
        padding: const EdgeInsets.only(bottom: 60.0),
        child: new Container(
          alignment: FractionalOffset.center,
          width: shrinkButtonAnimation.value,
          height: 60,
          decoration: BoxDecoration(
            color: Colors.orange,
            borderRadius: BorderRadius.all(const Radius.circular(30.0)),
          ),
          child: shrinkButtonAnimation.value > 75
              ? Text(
                  "Sign In",
                  style: TextStyle(
                      color: Colors.white,
                      fontSize: 20,
                      fontWeight: FontWeight.w300,
                      letterSpacing: 0.3),
                )
              : CircularProgressIndicator(
                  strokeWidth: 1.0,
                  valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                ),
        ));
  }

  @override
  _RegisterAnimationState createState() => _RegisterAnimationState(
      email: email, password: pass, cpassword: cpass, name: nama, room: room);
}

class _RegisterAnimationState extends State<RegisterAnimation> {
  _RegisterAnimationState(
      {this.email, this.password, this.cpassword, this.name, this.room});
  final String email;
  final String password;
  final String cpassword;
  final String name;
  final String room;
  

  Future<List> _register() async {
    if (widget.nama != "" &&
        widget.pass != "" &&
        widget.cpass != "" &&
        widget.email != "" &&
        widget.room != "") {
      var url = globals.url;
      final response = await http.post("${url}register", body: {
        "email": email,
        "password": password,
        "name": name,
        "room": room,
        "cpassword": cpassword,
      });
      if (response.statusCode == 200) {
        var data = json.decode(response.body);
        if (data['code'] == '0') {
          showDialog(
              context: context,
              builder: (BuildContext context) {
                return AlertDialog(
            
              title: Center(
                child: Text("Failed", style: TextStyle(fontWeight: FontWeight.bold),),
              ),
              content: Container(
                height: MediaQuery.of(context).size.height / 6,
                child: Center(
                  child: Column(
                    children: <Widget>[
                      Text(
                        data['message']
                      ),
                      Padding(
                        padding: const EdgeInsets.only(top : 30.0),
                        child: FlatButton(
                          color: Color(0xFF7A9BEE),
                          child: Text("OK", style: TextStyle(color: Colors.white),),
                          onPressed: () => Navigator.of(context).pop(),
                        ),
                      )
                    ],
                  ),
                ),
              ),
            );
              });
        } else if (data['code'] == '1') {
          Navigator.push(
              context,
              MaterialPageRoute(
                builder: (BuildContext context) => new Login(),
              ));
          showDialog(
              context: context,
              builder: (BuildContext context) {
                return AlertDialog(
            
              title: Center(
                child: Text("Success", style: TextStyle(fontWeight: FontWeight.bold),),
              ),
              content: Container(
                height: MediaQuery.of(context).size.height / 6,
                child: Center(
                  child: Column(
                    children: <Widget>[
                      Text(
                        data['message']
                      ),
                      Padding(
                        padding: const EdgeInsets.only(top : 30.0),
                        child: FlatButton(
                          color: Color(0xFF7A9BEE),
                          child: Text("OK", style: TextStyle(color: Colors.white),),
                          onPressed: () => Navigator.of(context).pop(),
                        ),
                      )
                    ],
                  ),
                ),
              ),
            );
              });
        }
      } else {
        showDialog(
            context: context,
            builder: (BuildContext context) {
              return AlertDialog(
            
              title: Center(
                child: Text("Failed", style: TextStyle(fontWeight: FontWeight.bold),),
              ),
              content: Container(
                height: MediaQuery.of(context).size.height / 6,
                child: Center(
                  child: Column(
                    children: <Widget>[
                      Text(
                        "Kesalahan Pada Koneksi"
                      ),
                      Padding(
                        padding: const EdgeInsets.only(top : 30.0),
                        child: FlatButton(
                          color: Color(0xFF7A9BEE),
                          child: Text("OK", style: TextStyle(color: Colors.white),),
                          onPressed: () => Navigator.of(context).pop(),
                        ),
                      )
                    ],
                  ),
                ),
              ),
            );
            });
      }
    } else {
      showDialog(
          context: context,
          builder: (BuildContext context) {
            return AlertDialog(
            
              title: Center(
                child: Text("Failed", style: TextStyle(fontWeight: FontWeight.bold),),
              ),
              content: Container(
                height: MediaQuery.of(context).size.height / 6,
                child: Center(
                  child: Column(
                    children: <Widget>[
                      Text(
                        "Harap Isi Semua Inputan"
                      ),
                      Padding(
                        padding: const EdgeInsets.only(top : 30.0),
                        child: FlatButton(
                          color: Color(0xFF7A9BEE),
                          child: Text("OK", style: TextStyle(color: Colors.white),),
                          onPressed: () => Navigator.of(context).pop(),
                        ),
                      )
                    ],
                  ),
                ),
              ),
            );
          });
    }
  }

  @override
  Widget build(BuildContext context) {
    widget.buttonController.addListener(() {
      if (widget.zoomAnimation.isCompleted) {
        _register();
      }
    });
    return new AnimatedBuilder(
      builder: widget._buildAnimation,
      animation: widget.buttonController,
    );
  }
}
