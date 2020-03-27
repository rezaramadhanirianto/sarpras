import 'package:flutter/material.dart';
import 'package:fancy_bottom_navigation/fancy_bottom_navigation.dart';
import 'package:sarpras/barcode.dart';
import 'package:sarpras/main.dart';
import 'package:sarpras/realHome.dart';
import 'package:sarpras/report.dart';
import 'package:dynamic_theme/dynamic_theme.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;
import 'globals.dart' as globals;

class Home extends StatefulWidget {
  final String email;

  Home({this.email});

  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  var a = false;
  void changeBrightness() {
    DynamicTheme.of(context).setBrightness(
        Theme.of(context).brightness == Brightness.light
            ? Brightness.dark
            : Brightness.light);
  }

  int _currentIndex = 0;
  final List<Widget> _children = [
    PlaceholderWidget(1),
    PlaceholderWidget(2),
    PlaceholderWidget(3),
  ];
  void onTabTapped(int index) {
    setState(() {
      _currentIndex = index;
    });
  }

  

  void logout() async {
    final response = await http.post("${globals.url}logout", body: {});
    if (response.statusCode == 200) {
      Navigator.of(context).push(MaterialPageRoute(
        builder: (BuildContext context) => new Login(),
      ));
      SharedPreferences prefs = await SharedPreferences.getInstance();
    prefs.clear();
      print("Berhasil Logout");
    } else {
      print("Gagal Logout");
    }
  }
  var email = "";
  void getEmail() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
     email = prefs.getString('email');
  }

  @override
  Widget build(BuildContext context) {
    getEmail();
    return WillPopScope(
      onWillPop: ()async=>false,
          child: Scaffold(
        
          appBar: new AppBar(
            title: new Text(
              "Sarana & Prasarana",
              style: TextStyle(
                  fontFamily: '',
                  fontSize: 25,
                  color: Colors.white,
                  fontWeight: FontWeight.w400),
            ),
            centerTitle: true,
            backgroundColor: Colors.orange[300],
            actions: <Widget>[
              new InkWell(
                  child: new Icon(
                    Icons.account_circle,
                    color: Colors.white,
                  ),
                  onTap: () {
                    showDialog(
                        context: context,
                        builder: (BuildContext context) {
                          return AlertDialog(
                            title: new Center(
                              child: Text('Profile'),
                            ),
                            content: Container(
                              // height: 425,
                              child: new Column(
                                children: <Widget>[
                                  InkWell(
                                    child: new Image.asset(
                                      'img/avatar2.png',
                                    ),
                                  ),
                                  Center(
                                    child: new Text(
                                      'Anda Login Sebagai',
                                      style: new TextStyle(
                                        fontSize: 20.0,
                                        fontWeight: FontWeight.w300,
                                      ),
                                    ),
                                  ),
                                  Center(
                                    child: new Text(
                                      '$email',
                                      style: new TextStyle(
                                        fontSize: 20.0,
                                        fontWeight: FontWeight.w700,
                                      ),
                                    ),
                                  ),
                                  Column(
                                    children: <Widget>[
                                      Padding(
                                        padding: const EdgeInsets.only(
                                            top: 50, bottom: 20.0),
                                      ),
                                      Center(
                                        child: InkWell(
                                          child: new Text(
                                            'Logout',
                                            style: new TextStyle(
                                              color: Colors.red,
                                              fontSize: 25.0,
                                              fontWeight: FontWeight.w900,
                                            ),
                                          ),
                                          onTap: () {
                                            Navigator.of(context)
                                                .push(MaterialPageRoute(
                                              builder: (BuildContext context) =>
                                                  new Login(),
                                            ));
                                            logout();
                                          },
                                        ),
                                      ),
                                    ],
                                  ),
                                  
                                ],
                              ),
                            ),
                          );
                        });
                  })
            ],
          ),
          drawer: Drawer(
            child: Center(
              child: new ListView(
                children: <Widget>[
                  Center(
                      child: Text(
                    "SETTINGS",
                    style: new TextStyle(fontSize: 30, fontFamily: 'Vibes'),
                  )),
                  Padding(
                    padding: const EdgeInsets.only(left: 10.0, top: 20),
                    child: Text("Dark Mode"),
                  ),
                  new SwitchListTile(
                    value: a,
                    onChanged: (value) => setState(() {
                      a = value;
                      changeBrightness();
                    }),
                  )
                ],
              ),
            ),
          ),
          body: _children[_currentIndex],
          bottomNavigationBar: FancyBottomNavigation(
            circleColor: Color(0xFF7A9BEE),
            inactiveIconColor: Color(0xFF7A9BEE),
            tabs: [
              TabData(iconData: Icons.home, title: "Home"),
              TabData(iconData: Icons.scanner, title: "Barcode"),
              TabData(iconData: Icons.mail, title: "Report"),
            ],
            onTabChangedListener: (position) {
              setState(() {
                _currentIndex = position;
              });
            },
          )),
    );
  }
}

class PlaceholderWidget extends StatelessWidget {
  final int i;

  PlaceholderWidget(this.i);

  @override
  Widget build(BuildContext context) {
    if (i == 1) {
      return new RealHome();
    } else if (i == 2) {
      return new Barcode();
    } else if (i == 3) {
      return new Report();
    }
  }
}
