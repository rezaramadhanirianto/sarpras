import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/scheduler.dart';
import 'package:flutter/animation.dart';
import 'package:sarpras/main.dart';
import 'package:sarpras/registerAnimation.dart';
import 'dart:async';
import 'globals.dart' as globals;
import 'package:http/http.dart' as http;

class Register extends StatefulWidget {
  @override
  _RegisterState createState() => _RegisterState();
}

class _RegisterState extends State<Register> with TickerProviderStateMixin {
  var statusClick = 0;

  AnimationController animationControllerButton;
  TextEditingController editingControllerUser;
  TextEditingController editingControllerPass;
  TextEditingController editingControllerCpass;
  TextEditingController editingControllerEmail;
  TextEditingController editingControllerRoom;
  String selected;
  List data = List();

  @override
  void initState() {
    _rooms();
    editingControllerPass = new TextEditingController(text: '');
    editingControllerUser = new TextEditingController(text: '');
    editingControllerCpass = new TextEditingController(text: '');
    editingControllerEmail = new TextEditingController(text: '');
    editingControllerRoom = new TextEditingController(text: '');

    super.initState();
    animationControllerButton =
        AnimationController(duration: Duration(seconds: 3), vsync: this)
          ..addStatusListener((status) {
            if (status == AnimationStatus.dismissed) {
              setState(() {
                statusClick = 0;
              });
            }
          });
  }

  @override
  void dispose() {
    super.dispose();
    animationControllerButton.dispose();
  }

  Future<Null> _playAnimation() async {
    try {
      await animationControllerButton.forward();
      await animationControllerButton.reverse();
    } on TickerCanceled {}
  }

  Future<List> _rooms() async {
    String str = "${globals.url}showroom";
    final response = await http.post(str, body: {});
    var res = json.decode(response.body);
    
      setState(() {
        data = res;
      });
    return json.decode(response.body);
  }

  @override
  Widget build(BuildContext context) {
    return new Scaffold(
      body: Container(
        decoration: BoxDecoration(
          image: DecorationImage(
              image: AssetImage('img/back.png'), fit: BoxFit.cover),
        ),
        child: Container(
          decoration: BoxDecoration(
            gradient: LinearGradient(
              colors: [
                Color.fromRGBO(162, 146, 199, 0.7),
                Color.fromRGBO(51, 51, 63, 0.8),
              ],
              begin: FractionalOffset.topCenter,
              end: FractionalOffset.bottomCenter,
            ),
          ),
          child: ListView(
            padding: EdgeInsets.all(0.0),
            children: <Widget>[
              Stack(
                alignment: AlignmentDirectional.bottomCenter,
                children: <Widget>[
                  Column(
                    children: <Widget>[
                      Padding(
                        padding: const EdgeInsets.only(top: 30.0),
                      ),
                      Container(
                        padding: const EdgeInsets.all(10.0),
                        child: Column(
                          children: <Widget>[
                            InkWell(
                              child: new Image.asset(
                                'img/logo.png',
                                width: 300,
                              ),
                            ),
                            Padding(padding: const EdgeInsets.all(10.0)),
                            TextField(
                              style: new TextStyle(color: Colors.white),
                              controller: editingControllerUser,
                              decoration: InputDecoration(
                                  icon: Icon(
                                    Icons.person_outline,
                                    color: Colors.white,
                                  ),
                                  hintText: "Nama",
                                  hintStyle:
                                      new TextStyle(color: Colors.white)),
                            ),
                            Padding(padding: const EdgeInsets.all(10.0)),
                            TextField(
                              keyboardType: TextInputType.emailAddress,
                              style: new TextStyle(color: Colors.white),
                              controller: editingControllerEmail,
                              decoration: InputDecoration(
                                  icon: Icon(
                                    Icons.mail,
                                    color: Colors.white,
                                  ),
                                  hintText: "Email",
                                  hintStyle:
                                      new TextStyle(color: Colors.white)),
                            ),
                            Padding(padding: const EdgeInsets.all(10.0)),
                            InputDecorator(
                              decoration: InputDecoration(
                                prefixStyle: TextStyle(color: Colors.white),
                                prefixText: "Ruangan :     ",
                                icon: Icon(
                                  Icons.view_column,
                                  color: Colors.white,
                                ),
                                border: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(5.0)),
                              ),
                              child: DropdownButton(
                                style: TextStyle(color: Colors.grey[400]),
                                items: data.map((item) {
                                  return new DropdownMenuItem(
                                    child: new Text(item['room']),
                                    value: item['id'].toString(),
                                  );
                                }).toList(),
                                onChanged: (newVal) {
                                  setState(() {
                                    selected = newVal;
                                  });
                                },
                                value: selected,
                              ),
                            ),
                            Padding(padding: const EdgeInsets.all(10.0)),
                            TextField(
                              obscureText: true,
                              style: new TextStyle(color: Colors.white),
                              controller: editingControllerPass,
                              decoration: InputDecoration(
                                  icon: Icon(
                                    Icons.lock_outline,
                                    color: Colors.white,
                                  ),
                                  fillColor: Colors.white,
                                  focusColor: Colors.white,
                                  hintText: "Password",
                                  hintStyle:
                                      new TextStyle(color: Colors.white)),
                            ),
                            Padding(padding: const EdgeInsets.all(10.0)),
                            TextField(
                              obscureText: true,
                              style: new TextStyle(color: Colors.white),
                              controller: editingControllerCpass,
                              decoration: InputDecoration(
                                  icon: Icon(
                                    Icons.lock,
                                    color: Colors.white,
                                  ),
                                  fillColor: Colors.white,
                                  focusColor: Colors.white,
                                  hintText: "Confirm Password",
                                  hintStyle:
                                      new TextStyle(color: Colors.white)),
                            ),
                            FlatButton(
                              padding:
                                  const EdgeInsets.only(top: 120, bottom: 30),
                              onPressed: () {},
                              child: Text(
                                " ",
                                style: TextStyle(
                                    fontSize: 12.0,
                                    color: Colors.white,
                                    fontWeight: FontWeight.w300,
                                    letterSpacing: 0.5),
                              ),
                            ),
                          ],
                        ),
                      )
                    ],
                  ),
                  statusClick == 0
                      ? new InkWell(
                          onTap: () {
                            setState(() {
                              statusClick = 1;
                            });
                            _playAnimation();
                          },
                          child: new SignIn(),
                        )
                      : new RegisterAnimation(
                          buttonController: animationControllerButton.view,
                          nama: editingControllerUser.text,
                          email: editingControllerEmail.text,
                          cpass: editingControllerCpass.text,
                          pass: editingControllerPass.text,
                          room: selected,
                        ),
                  FlatButton(
                    onPressed: () {
                      Navigator.of(context).push(MaterialPageRoute(
                        builder: (BuildContext context) => new Login(),
                      ));
                    },
                    child: Text(
                      "Have an account? Click here",
                      style: TextStyle(
                          fontSize: 12.0,
                          color: Colors.white,
                          fontWeight: FontWeight.w300,
                          letterSpacing: 0.5),
                    ),
                  ),
                ],
              )
            ],
          ),
        ),
      ),
    );
  }
}

class SignIn extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(60.0),
      child: Container(
        alignment: FractionalOffset.center,
        width: 320,
        height: 60,
        decoration: BoxDecoration(
          color: Colors.orange,
          borderRadius: BorderRadius.all(const Radius.circular(30.0)),
        ),
        child: Text(
          "Sign Up",
          style: TextStyle(
              color: Colors.white,
              fontSize: 20,
              fontWeight: FontWeight.w300,
              letterSpacing: 0.3),
        ),
      ),
    );
  }
}
