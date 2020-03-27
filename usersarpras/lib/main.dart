import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/scheduler.dart';
import 'package:flutter/animation.dart';
import 'package:advanced_splashscreen/advanced_splashscreen.dart';
import 'package:flutter/services.dart';
import 'globals.dart' as globals;
import 'package:flutter/material.dart' as prefix0;
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:sarpras/register.dart';
import 'package:dynamic_theme/dynamic_theme.dart';
import 'loginAnimation.dart';
import 'dart:async';
import 'package:progress_dialog/progress_dialog.dart';

void main() {
  runApp(MaterialApp(
    debugShowCheckedModeBanner: false,
    home: AdvancedSplashScreen(
      child: First(),
      seconds: 2,
      colorList: [
        Colors.orange[300],
        Colors.orange[200],
        Colors.orange[100],
      ],
      appIcon: "img/logo_text.png",
      appTitle: "Sarana & Prasarana",
      appTitleStyle:
          new TextStyle(color: Colors.black, fontFamily: 'Vibes', fontSize: 30),
    ),
  ));
}

class First extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return new DynamicTheme(
        defaultBrightness: Brightness.light,
        data: (brightness) => new ThemeData(
              primarySwatch: Colors.indigo,
              brightness: brightness,
            ),
        themedWidgetBuilder: (context, theme) {
          return new MaterialApp(
            title: 'Flutter Demo',
            theme: theme,
            home: new Login(),
          );
        });
  }
}

class Login extends StatefulWidget {
  @override
  _LoginState createState() => _LoginState();
}

class _LoginState extends State<Login> with TickerProviderStateMixin {
  var statusClick = 0;
  AnimationController animationControllerButton;
  TextEditingController editingControllerUser;
  TextEditingController editingControllerPass;
  ProgressDialog pr;
  var scaffold = GlobalKey();
  var id;

  @override
  void initState() {
    editingControllerPass = new TextEditingController(text: '');
    editingControllerUser = new TextEditingController(text: '');
    super.initState();
    if (globals.number == 0) {
      WidgetsBinding.instance
          .addPostFrameCallback((_) => load(scaffold.currentContext));
      globals.number = 1;
    }
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

  void load(BuildContext context) async {
    pr = new ProgressDialog(scaffold.currentContext,
        type: ProgressDialogType.Normal);
    pr.style(
        message: 'Memeriksa Jaringan...',
        borderRadius: 10.0,
        backgroundColor: Colors.orange[300],
        elevation: 10.0,
        insetAnimCurve: Curves.easeInOut,
        progress: 0.0,
        maxProgress: 100.0,
        progressTextStyle: TextStyle(
            color: Colors.white, fontSize: 15.0, fontWeight: FontWeight.w400),
        messageTextStyle: TextStyle(
            color: Colors.white, fontSize: 15.0, fontWeight: FontWeight.w600));
    pr.show();
    try {
      String str = "${globals.url}load";
      final response = await http.post(str, body: {"id": "1"});
      var data = json.decode(response.body);
      if (data['code'] == "1") {
        pr.hide();
      } else {
        pr.hide();
        showDialog(
            context: scaffold.currentContext,
            builder: (BuildContext context) {
              return AlertDialog(
                title: Center(
                  child: Text(
                    "Gagal",
                    style: TextStyle(fontWeight: FontWeight.bold),
                  ),
                ),
                content: Container(
                  height: MediaQuery.of(context).size.height / 6,
                  child: Center(
                    child: Column(
                      children: <Widget>[
                        Text("Kesalahan Pada Jaringan"),
                        Padding(
                          padding: const EdgeInsets.only(top: 30.0),
                          child: FlatButton(
                            color: Color(0xFF7A9BEE),
                            child: Text(
                              "OK",
                              style: TextStyle(color: Colors.white),
                            ),
                            onPressed: () {
                              Navigator.of(context).pop();
                              repeat(context);
                            },
                          ),
                        )
                      ],
                    ),
                  ),
                ),
              );
            });
      }
    } catch (_) {
      print("Not Connected");
      pr.hide();
      showDialog(
          context: scaffold.currentContext,
          builder: (BuildContext context) {
            return AlertDialog(
              title: Center(
                child: Text(
                  "Gagal",
                  style: TextStyle(fontWeight: FontWeight.bold),
                ),
              ),
              content: Container(
                height: MediaQuery.of(context).size.height / 6,
                child: Center(
                  child: Column(
                    children: <Widget>[
                      Text("Kesalahan Pada Jaringan"),
                      Padding(
                        padding: const EdgeInsets.only(top: 30.0),
                        child: FlatButton(
                          color: Color(0xFF7A9BEE),
                          child: Text(
                            "OK",
                            style: TextStyle(color: Colors.white),
                          ),
                          onPressed: () {
                            Navigator.of(context).pop();
                            repeat(context);
                          },
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

  void repeat(BuildContext context) {
    load(scaffold.currentContext);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: scaffold,
      resizeToAvoidBottomPadding: false,
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
                        padding: const EdgeInsets.only(top: 50.0),
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
                              keyboardType: TextInputType.emailAddress,
                              style: new TextStyle(color: Colors.white),
                              controller: editingControllerUser,
                              decoration: InputDecoration(
                                  icon: Icon(
                                    Icons.person_outline,
                                    color: Colors.white,
                                  ),
                                  hintText: "Email",
                                  hintStyle:
                                      new TextStyle(color: Colors.white)),
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
                            FlatButton(
                              padding:
                                  const EdgeInsets.only(top: 200, bottom: 30),
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
                      : new StartAnimation(
                          buttonController: animationControllerButton.view,
                          user: editingControllerUser.text,
                          pass: editingControllerPass.text,
                          context: context,
                        ),
                  FlatButton(
                    onPressed: () {
                      Navigator.of(context).push(MaterialPageRoute(
                        builder: (BuildContext context) => new Register(),
                      ));
                    },
                    child: Text(
                      "Don't have an account? Sign Up here",
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
          "Sign In",
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
