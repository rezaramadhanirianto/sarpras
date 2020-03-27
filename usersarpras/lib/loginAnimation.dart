import 'package:fancy_dialog/FancyGif.dart';
import 'package:flutter/material.dart';
import 'package:sarpras/home.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'globals.dart' as globals;
import 'package:fancy_dialog/fancy_dialog.dart';

class StartAnimation extends StatefulWidget {
  StartAnimation(
      {Key key, this.buttonController, this.user, this.pass, this.context})
      : shrinkButtonAnimation = new Tween(begin: 320.0, end: 70.0).animate(
          CurvedAnimation(
              parent: buttonController, curve: Interval(0.0, 0.150)),
        ),
        zoomAnimation =
            new Tween(begin: 70.0, end: 900.0).animate(CurvedAnimation(
                parent: buttonController,
                curve: Interval(
                  0.150,
                  0.999,
                  curve: Curves.bounceInOut,
                ))),
        super(key: key);

  final AnimationController buttonController;
  final Animation shrinkButtonAnimation;
  final Animation zoomAnimation;
  final String user;
  final String pass;
  final BuildContext context;

  Widget _buildAnimation(BuildContext context, Widget child) {
    return SingleChildScrollView(
      child: Padding(
          padding: const EdgeInsets.only(bottom: 60.0),
          child: zoomAnimation.value <= 300
              ? new Container(
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
                          valueColor:
                              AlwaysStoppedAnimation<Color>(Colors.white),
                        ),
                )
              : user != ""
                  ? Container(
                      width: zoomAnimation.value,
                      height: zoomAnimation.value,
                      decoration: BoxDecoration(
                        color: Colors.orange,
                        shape: zoomAnimation.value < 600
                            ? BoxShape.circle
                            : BoxShape.rectangle,
                      ),
                    )
                  : new Container(
                      alignment: FractionalOffset.center,
                      width: shrinkButtonAnimation.value,
                      height: 60,
                      decoration: BoxDecoration(
                        color: Colors.orange,
                        borderRadius:
                            BorderRadius.all(const Radius.circular(30.0)),
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
                              valueColor:
                                  AlwaysStoppedAnimation<Color>(Colors.white),
                            ),
                    )),
    );
  }

  @override
  _StartAnimationState createState() =>
      _StartAnimationState(user: user, pass: pass);
}

class _StartAnimationState extends State<StartAnimation> {
  _StartAnimationState({this.user, this.pass});
  final String user;
  final String pass;

  Future<List> _login() async {
    if (widget.user == "" || widget.pass == "") {
      showDialog(
          context: context,
          builder: (BuildContext context) {
            return AlertDialog(
              title: Center(
                child: Text(
                  "Failed",
                  style: TextStyle(fontWeight: FontWeight.bold),
                ),
              ),
              content: Container(
                height: MediaQuery.of(context).size.height / 6,
                child: Center(
                  child: Column(
                    children: <Widget>[
                      Text("Silahkan Isi Semua Inputan"),
                      Padding(
                        padding: const EdgeInsets.only(top: 30.0),
                        child: FlatButton(
                          color: Color(0xFF7A9BEE),
                          child: Text(
                            "OK",
                            style: TextStyle(color: Colors.white),
                          ),
                          onPressed: () => Navigator.of(context).pop(),
                        ),
                      )
                    ],
                  ),
                ),
              ),
            );
          });
    } else {
      var url = globals.url;
      final response = await http.post("${globals.url}login", body: {
        "email": user,
        "password": pass,
      });
      // print(response.statusCode);
      if (response.statusCode == 200) {
        var data = json.decode(response.body);
        // print(data['id']);
        if (data['code'] == "1") {
          if (data['id'] != '0') {
            // Session
            SharedPreferences prefs = await SharedPreferences.getInstance();
            prefs.setInt('id', data['id']);
            prefs.setString('email', data['email']);

            // Move
            Navigator.push(
                context,
                MaterialPageRoute(
                    builder: (BuildContext context) => Home(
                          email: data['email'],
                        )));
          } else {
                  showDialog(
                      context: context,
                      builder: (BuildContext context) {
                        return AlertDialog(
                          title: Center(
                            child: Text(
                              "Failed",
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                          ),
                          content: Container(
                            height: MediaQuery.of(context).size.height / 6,
                            child: Center(
                              child: Column(
                                children: <Widget>[
                                  Text("Kesalahan Pada Koneksi"),
                                  Padding(
                                    padding: const EdgeInsets.only(top: 30.0),
                                    child: FlatButton(
                                      color: Color(0xFF7A9BEE),
                                      child: Text(
                                        "OK",
                                        style: TextStyle(color: Colors.white),
                                      ),
                                      onPressed: () =>
                                          Navigator.of(context).pop(),
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
                          child: Text(
                            "Failed",
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),
                        ),
                        content: Container(
                          height: MediaQuery.of(context).size.height / 6,
                          child: Center(
                            child: Column(
                              children: <Widget>[
                                Text(data['message']),
                                Padding(
                                  padding: const EdgeInsets.only(top: 30.0),
                                  child: FlatButton(
                                    color: Color(0xFF7A9BEE),
                                    child: Text(
                                      "OK",
                                      style: TextStyle(color: Colors.white),
                                    ),
                                    onPressed: () =>
                                        Navigator.of(context).pop(),
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
                        child: Text(
                          "Failed",
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),
                      ),
                      content: Container(
                        height: MediaQuery.of(context).size.height / 6,
                        child: Center(
                          child: Column(
                            children: <Widget>[
                              Text("Kesalahan Pada Koneksi"),
                              Padding(
                                padding: const EdgeInsets.only(top: 30.0),
                                child: FlatButton(
                                  color: Color(0xFF7A9BEE),
                                  child: Text(
                                    "OK",
                                    style: TextStyle(color: Colors.white),
                                  ),
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
  }

  @override
  Widget build(BuildContext context) {
    widget.buttonController.addListener(() {
      if (widget.zoomAnimation.isCompleted) {
        _login();
      }
    });
    return new AnimatedBuilder(
      builder: widget._buildAnimation,
      animation: widget.buttonController,
    );
  }
}
