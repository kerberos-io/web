(function (root, factory) {
    if ( typeof define === 'function' && define.amd ) {
        define('streamer', factory(root));
    } else if ( typeof exports === 'object' ) {
        module.exports = factory(root);
    } else {
        root.streamer = factory(root);
    }
})(window || this, function (root) {

    'use strict';

/**
 * @author Russell Toris - rctoris@wpi.edu
 */

/*!
 * EventEmitter2
 * https://github.com/hij1nx/EventEmitter2
 *
 * Copyright (c) 2013 hij1nx
 * Licensed under the MIT license.
 */

  var isArray = Array.isArray ? Array.isArray : function _isArray(obj) {
    return Object.prototype.toString.call(obj) === "[object Array]";
  };
  var defaultMaxListeners = 10;

  function init() {
    this._events = {};
    if (this._conf) {
      configure.call(this, this._conf);
    }
  }

  function configure(conf) {
    if (conf) {

      this._conf = conf;

      conf.delimiter && (this.delimiter = conf.delimiter);
      conf.maxListeners && (this._events.maxListeners = conf.maxListeners);
      conf.wildcard && (this.wildcard = conf.wildcard);
      conf.newListener && (this.newListener = conf.newListener);

      if (this.wildcard) {
        this.listenerTree = {};
      }
    }
  }

  function EventEmitter(conf) {
    this._events = {};
    this.newListener = false;
    configure.call(this, conf);
  }

  //
  // Attention, function return type now is array, always !
  // It has zero elements if no any matches found and one or more
  // elements (leafs) if there are matches
  //
  function searchListenerTree(handlers, type, tree, i) {
    if (!tree) {
      return [];
    }
    var listeners=[], leaf, len, branch, xTree, xxTree, isolatedBranch, endReached,
        typeLength = type.length, currentType = type[i], nextType = type[i+1];
    if (i === typeLength && tree._listeners) {
      //
      // If at the end of the event(s) list and the tree has listeners
      // invoke those listeners.
      //
      if (typeof tree._listeners === 'function') {
        handlers && handlers.push(tree._listeners);
        return [tree];
      } else {
        for (leaf = 0, len = tree._listeners.length; leaf < len; leaf++) {
          handlers && handlers.push(tree._listeners[leaf]);
        }
        return [tree];
      }
    }

    if ((currentType === '*' || currentType === '**') || tree[currentType]) {
      //
      // If the event emitted is '*' at this part
      // or there is a concrete match at this patch
      //
      if (currentType === '*') {
        for (branch in tree) {
          if (branch !== '_listeners' && tree.hasOwnProperty(branch)) {
            listeners = listeners.concat(searchListenerTree(handlers, type, tree[branch], i+1));
          }
        }
        return listeners;
      } else if(currentType === '**') {
        endReached = (i+1 === typeLength || (i+2 === typeLength && nextType === '*'));
        if(endReached && tree._listeners) {
          // The next element has a _listeners, add it to the handlers.
          listeners = listeners.concat(searchListenerTree(handlers, type, tree, typeLength));
        }

        for (branch in tree) {
          if (branch !== '_listeners' && tree.hasOwnProperty(branch)) {
            if(branch === '*' || branch === '**') {
              if(tree[branch]._listeners && !endReached) {
                listeners = listeners.concat(searchListenerTree(handlers, type, tree[branch], typeLength));
              }
              listeners = listeners.concat(searchListenerTree(handlers, type, tree[branch], i));
            } else if(branch === nextType) {
              listeners = listeners.concat(searchListenerTree(handlers, type, tree[branch], i+2));
            } else {
              // No match on this one, shift into the tree but not in the type array.
              listeners = listeners.concat(searchListenerTree(handlers, type, tree[branch], i));
            }
          }
        }
        return listeners;
      }

      listeners = listeners.concat(searchListenerTree(handlers, type, tree[currentType], i+1));
    }

    xTree = tree['*'];
    if (xTree) {
      //
      // If the listener tree will allow any match for this part,
      // then recursively explore all branches of the tree
      //
      searchListenerTree(handlers, type, xTree, i+1);
    }

    xxTree = tree['**'];
    if(xxTree) {
      if(i < typeLength) {
        if(xxTree._listeners) {
          // If we have a listener on a '**', it will catch all, so add its handler.
          searchListenerTree(handlers, type, xxTree, typeLength);
        }

        // Build arrays of matching next branches and others.
        for(branch in xxTree) {
          if(branch !== '_listeners' && xxTree.hasOwnProperty(branch)) {
            if(branch === nextType) {
              // We know the next element will match, so jump twice.
              searchListenerTree(handlers, type, xxTree[branch], i+2);
            } else if(branch === currentType) {
              // Current node matches, move into the tree.
              searchListenerTree(handlers, type, xxTree[branch], i+1);
            } else {
              isolatedBranch = {};
              isolatedBranch[branch] = xxTree[branch];
              searchListenerTree(handlers, type, { '**': isolatedBranch }, i+1);
            }
          }
        }
      } else if(xxTree._listeners) {
        // We have reached the end and still on a '**'
        searchListenerTree(handlers, type, xxTree, typeLength);
      } else if(xxTree['*'] && xxTree['*']._listeners) {
        searchListenerTree(handlers, type, xxTree['*'], typeLength);
      }
    }

    return listeners;
  }

  function growListenerTree(type, listener) {

    type = typeof type === 'string' ? type.split(this.delimiter) : type.slice();

    //
    // Looks for two consecutive '**', if so, don't add the event at all.
    //
    for(var i = 0, len = type.length; i+1 < len; i++) {
      if(type[i] === '**' && type[i+1] === '**') {
        return;
      }
    }

    var tree = this.listenerTree;
    var name = type.shift();

    while (name) {

      if (!tree[name]) {
        tree[name] = {};
      }

      tree = tree[name];

      if (type.length === 0) {

        if (!tree._listeners) {
          tree._listeners = listener;
        }
        else if(typeof tree._listeners === 'function') {
          tree._listeners = [tree._listeners, listener];
        }
        else if (isArray(tree._listeners)) {

          tree._listeners.push(listener);

          if (!tree._listeners.warned) {

            var m = defaultMaxListeners;

            if (typeof this._events.maxListeners !== 'undefined') {
              m = this._events.maxListeners;
            }

            if (m > 0 && tree._listeners.length > m) {

              tree._listeners.warned = true;
              console.error('(node) warning: possible EventEmitter memory ' +
                            'leak detected. %d listeners added. ' +
                            'Use emitter.setMaxListeners() to increase limit.',
                            tree._listeners.length);
              console.trace();
            }
          }
        }
        return true;
      }
      name = type.shift();
    }
    return true;
  }

  // By default EventEmitters will print a warning if more than
  // 10 listeners are added to it. This is a useful default which
  // helps finding memory leaks.
  //
  // Obviously not all Emitters should be limited to 10. This function allows
  // that to be increased. Set to zero for unlimited.

  EventEmitter.prototype.delimiter = '.';

  EventEmitter.prototype.setMaxListeners = function(n) {
    this._events || init.call(this);
    this._events.maxListeners = n;
    if (!this._conf) this._conf = {};
    this._conf.maxListeners = n;
  };

  EventEmitter.prototype.event = '';

  EventEmitter.prototype.once = function(event, fn) {
    this.many(event, 1, fn);
    return this;
  };

  EventEmitter.prototype.many = function(event, ttl, fn) {
    var self = this;

    if (typeof fn !== 'function') {
      throw new Error('many only accepts instances of Function');
    }

    function listener() {
      if (--ttl === 0) {
        self.off(event, listener);
      }
      fn.apply(this, arguments);
    }

    listener._origin = fn;

    this.on(event, listener);

    return self;
  };

  EventEmitter.prototype.emit = function() {

    this._events || init.call(this);

    var type = arguments[0];

    if (type === 'newListener' && !this.newListener) {
      if (!this._events.newListener) { return false; }
    }

    // Loop through the *_all* functions and invoke them.
    if (this._all) {
      var l = arguments.length;
      var args = new Array(l - 1);
      for (var i = 1; i < l; i++) args[i - 1] = arguments[i];
      for (i = 0, l = this._all.length; i < l; i++) {
        this.event = type;
        this._all[i].apply(this, args);
      }
    }

    // If there is no 'error' event listener then throw.
    if (type === 'error') {

      if (!this._all &&
        !this._events.error &&
        !(this.wildcard && this.listenerTree.error)) {

        if (arguments[1] instanceof Error) {
          throw arguments[1]; // Unhandled 'error' event
        } else {
          throw new Error("Uncaught, unspecified 'error' event.");
        }
        return false;
      }
    }

    var handler;

    if(this.wildcard) {
      handler = [];
      var ns = typeof type === 'string' ? type.split(this.delimiter) : type.slice();
      searchListenerTree.call(this, handler, ns, this.listenerTree, 0);
    }
    else {
      handler = this._events[type];
    }

    if (typeof handler === 'function') {
      this.event = type;
      if (arguments.length === 1) {
        handler.call(this);
      }
      else if (arguments.length > 1)
        switch (arguments.length) {
          case 2:
            handler.call(this, arguments[1]);
            break;
          case 3:
            handler.call(this, arguments[1], arguments[2]);
            break;
          // slower
          default:
            var l = arguments.length;
            var args = new Array(l - 1);
            for (var i = 1; i < l; i++) args[i - 1] = arguments[i];
            handler.apply(this, args);
        }
      return true;
    }
    else if (handler) {
      var l = arguments.length;
      var args = new Array(l - 1);
      for (var i = 1; i < l; i++) args[i - 1] = arguments[i];

      var listeners = handler.slice();
      for (var i = 0, l = listeners.length; i < l; i++) {
        this.event = type;
        listeners[i].apply(this, args);
      }
      return (listeners.length > 0) || !!this._all;
    }
    else {
      return !!this._all;
    }

  };

  EventEmitter.prototype.on = function(type, listener) {

    if (typeof type === 'function') {
      this.onAny(type);
      return this;
    }

    if (typeof listener !== 'function') {
      throw new Error('on only accepts instances of Function');
    }
    this._events || init.call(this);

    // To avoid recursion in the case that type == "newListeners"! Before
    // adding it to the listeners, first emit "newListeners".
    this.emit('newListener', type, listener);

    if(this.wildcard) {
      growListenerTree.call(this, type, listener);
      return this;
    }

    if (!this._events[type]) {
      // Optimize the case of one listener. Don't need the extra array object.
      this._events[type] = listener;
    }
    else if(typeof this._events[type] === 'function') {
      // Adding the second element, need to change to array.
      this._events[type] = [this._events[type], listener];
    }
    else if (isArray(this._events[type])) {
      // If we've already got an array, just append.
      this._events[type].push(listener);

      // Check for listener leak
      if (!this._events[type].warned) {

        var m = defaultMaxListeners;

        if (typeof this._events.maxListeners !== 'undefined') {
          m = this._events.maxListeners;
        }

        if (m > 0 && this._events[type].length > m) {

          this._events[type].warned = true;
          console.error('(node) warning: possible EventEmitter memory ' +
                        'leak detected. %d listeners added. ' +
                        'Use emitter.setMaxListeners() to increase limit.',
                        this._events[type].length);
          console.trace();
        }
      }
    }
    return this;
  };

  EventEmitter.prototype.onAny = function(fn) {

    if (typeof fn !== 'function') {
      throw new Error('onAny only accepts instances of Function');
    }

    if(!this._all) {
      this._all = [];
    }

    // Add the function to the event listener collection.
    this._all.push(fn);
    return this;
  };

  EventEmitter.prototype.addListener = EventEmitter.prototype.on;

  EventEmitter.prototype.off = function(type, listener) {
    if (typeof listener !== 'function') {
      throw new Error('removeListener only takes instances of Function');
    }

    var handlers,leafs=[];

    if(this.wildcard) {
      var ns = typeof type === 'string' ? type.split(this.delimiter) : type.slice();
      leafs = searchListenerTree.call(this, null, ns, this.listenerTree, 0);
    }
    else {
      // does not use listeners(), so no side effect of creating _events[type]
      if (!this._events[type]) return this;
      handlers = this._events[type];
      leafs.push({_listeners:handlers});
    }

    for (var iLeaf=0; iLeaf<leafs.length; iLeaf++) {
      var leaf = leafs[iLeaf];
      handlers = leaf._listeners;
      if (isArray(handlers)) {

        var position = -1;

        for (var i = 0, length = handlers.length; i < length; i++) {
          if (handlers[i] === listener ||
            (handlers[i].listener && handlers[i].listener === listener) ||
            (handlers[i]._origin && handlers[i]._origin === listener)) {
            position = i;
            break;
          }
        }

        if (position < 0) {
          continue;
        }

        if(this.wildcard) {
          leaf._listeners.splice(position, 1);
        }
        else {
          this._events[type].splice(position, 1);
        }

        if (handlers.length === 0) {
          if(this.wildcard) {
            delete leaf._listeners;
          }
          else {
            delete this._events[type];
          }
        }
        return this;
      }
      else if (handlers === listener ||
        (handlers.listener && handlers.listener === listener) ||
        (handlers._origin && handlers._origin === listener)) {
        if(this.wildcard) {
          delete leaf._listeners;
        }
        else {
          delete this._events[type];
        }
      }
    }

    return this;
  };

  EventEmitter.prototype.offAny = function(fn) {
    var i = 0, l = 0, fns;
    if (fn && this._all && this._all.length > 0) {
      fns = this._all;
      for(i = 0, l = fns.length; i < l; i++) {
        if(fn === fns[i]) {
          fns.splice(i, 1);
          return this;
        }
      }
    } else {
      this._all = [];
    }
    return this;
  };

  EventEmitter.prototype.removeListener = EventEmitter.prototype.off;

  EventEmitter.prototype.removeAllListeners = function(type) {
    if (arguments.length === 0) {
      !this._events || init.call(this);
      return this;
    }

    if(this.wildcard) {
      var ns = typeof type === 'string' ? type.split(this.delimiter) : type.slice();
      var leafs = searchListenerTree.call(this, null, ns, this.listenerTree, 0);

      for (var iLeaf=0; iLeaf<leafs.length; iLeaf++) {
        var leaf = leafs[iLeaf];
        leaf._listeners = null;
      }
    }
    else {
      if (!this._events[type]) return this;
      this._events[type] = null;
    }
    return this;
  };

  EventEmitter.prototype.listeners = function(type) {
    if(this.wildcard) {
      var handlers = [];
      var ns = typeof type === 'string' ? type.split(this.delimiter) : type.slice();
      searchListenerTree.call(this, handlers, ns, this.listenerTree, 0);
      return handlers;
    }

    this._events || init.call(this);

    if (!this._events[type]) this._events[type] = [];
    if (!isArray(this._events[type])) {
      this._events[type] = [this._events[type]];
    }
    return this._events[type];
  };

  EventEmitter.prototype.listenersAny = function() {

    if(this._all) {
      return this._all;
    }
    else {
      return [];
    }

  };




var MJPEGCANVAS = MJPEGCANVAS || {
  REVISION : '0.4.0'
};

/**
 * @author Russell Toris - rctoris@wpi.edu
 */

/**
 * A MultiStreamViewer can be used to stream multiple MJPEG topics into a canvas.
 *
 * Emits the following events:
 *   * 'warning' - emitted if the given topic is unavailable
 *   * 'change' - emitted with the topic name that the canvas was changed to
 *
 * @constructor
 * @param options - possible keys include:
 *   * divID - the ID of the HTML div to place the canvas in
 *   * width - the width of the canvas
 *   * height - the height of the canvas
 *   * host - the hostname of the MJPEG server
 *   * port (optional) - the port to connect to
 *   * quality (optional) - the quality of the stream (from 1-100)
 *   * topics - an array of topics to stream
 *   * labels (optional) - an array of labels associated with each topic
 *   * defaultStream (optional) - the index of the default stream to use
 */
MJPEGCANVAS.MultiStreamViewer = function(options) {
  var that = this;
  options = options || {};
  var divID = options.divID;
  var width = options.width;
  var height = options.height;
  var host = options.host;
  var port = options.port || 8080;
  var quality = options.quality;
  var topics = options.topics;
  var labels = options.labels;
  var defaultStream = options.defaultStream || 0;
  var currentTopic = topics[defaultStream];

  // create an overlay canvas for the button
  var canvas = document.createElement('canvas');
  canvas.width = width;
  canvas.height = height;
  var context = canvas.getContext('2d');

  // menu div
  var menu = document.createElement('div');
  menu.style.display = 'none';
  document.getElementsByTagName('body')[0].appendChild(menu);

  // button for the error
  var buttonHeight = height / 8;
  var buttonPadding = 10;
  var button = new MJPEGCANVAS.Button({
    text : 'Edit',
    height : buttonHeight
  });
  var buttonWidth = button.width;

  // use a regular viewer internally
  var viewer = new MJPEGCANVAS.Viewer({
    divID : divID,
    width : width,
    height : height,
    host : host,
    port : port,
    quality : quality,
    topic : currentTopic,
    overlay : canvas
  });

  // catch the events
  viewer.on('warning', function(warning) {
    that.emit('warning', warning);
  });
  viewer.on('change', function(topic) {
    currentTopic = topic;
    that.emit('change', topic);
  });

  /**
   * Clear the button from the overlay canvas.
   */
  function clearButton() {
    if (buttonTimer) {
      window.clearInterval(buttonTimer);
      // clear the button
      canvas.width = canvas.width;
      hasButton = false;
    }
  }

  /**
   * Fades the stream by putting an overlay on it.
   */
  function fadeImage() {
    canvas.width = canvas.width;
    // create the white box
    context.globalAlpha = 0.44;
    context.beginPath();
    context.rect(0, 0, width, height);
    context.fillStyle = '#fefefe';
    context.fill();
    context.globalAlpha = 1;
  }

  // add the event listener
  var buttonTimer = null;
  var menuOpen = false;
  var hasButton = false;
  viewer.canvas.addEventListener('mousemove', function(e) {
    clearButton();

    if (!menuOpen) {
      hasButton = true;
      // add the button
      button.redraw();
      context.drawImage(button.canvas, buttonPadding, height - (buttonHeight + buttonPadding));

      // display the button for 3 seconds
      buttonTimer = setInterval(function() {
        // clear the overlay canvas
        clearButton();
      }, 3000);
    } else {
      fadeImage();
    }
  }, false);

  // add the click listener
  viewer.canvas.addEventListener('click', function(e) {
    // check if the button is there
    if (hasButton) {
      // determine the click position
      var offsetLeft = 0;
      var offsetTop = 0;
      var element = viewer.canvas;
      while (element && !isNaN(element.offsetLeft) && !isNaN(element.offsetTop)) {
        offsetLeft += element.offsetLeft - element.scrollLeft;
        offsetTop += element.offsetTop - element.scrollTop;
        element = element.offsetParent;
      }

      var x = e.pageX - offsetLeft;
      var y = e.pageY - offsetTop;

      // check if we are in the 'edit' button
      if (x < (buttonWidth + buttonPadding) && x > buttonPadding
          && y > (height - (buttonHeight + buttonPadding)) && y < height - buttonPadding) {
        menuOpen = true;
        clearButton();

        // create the menu
        var heading = document.createElement('span');
        heading.innerHTML = '<h2>Camera Streams</h2><hr /><br />';
        menu.appendChild(heading);
        var form = document.createElement('form');
        var streamLabel = document.createElement('label');
        streamLabel.setAttribute('for', 'stream');
        streamLabel.innerHTML = 'Stream: ';
        form.appendChild(streamLabel);
        var streamMenu = document.createElement('select');
        streamMenu.setAttribute('name', 'stream');
        // add each option
        for ( var i = 0; i < topics.length; i++) {
          var option = document.createElement('option');
          // check if this is the selected option
          if (topics[i] === currentTopic) {
            option.setAttribute('selected', 'selected');
          }
          option.setAttribute('value', topics[i]);
          // check for a label
          if (labels) {
            option.innerHTML = labels[i];
          } else {
            option.innerHTML += topics[i];
          }
          streamMenu.appendChild(option);
        }
        form.appendChild(streamMenu);
        menu.appendChild(form);
        menu.appendChild(document.createElement('br'));
        var close = document.createElement('button');
        close.innerHTML = 'Close';
        menu.appendChild(close);

        // display the menu
        menu.style.position = 'absolute';
        menu.style.top = offsetTop + 'px';
        menu.style.left = offsetLeft + 'px';
        menu.style.width = width + 'px';
        menu.style.display = 'block';

        streamMenu.addEventListener('click', function() {
          var topic = streamMenu.options[streamMenu.selectedIndex].value;
          // make sure it is a new stream
          if (topic !== currentTopic) {
            viewer.changeStream(topic);
          }
        }, false);

        // handle the interactions
        close.addEventListener('click', function(e) {
          // close the menu
          menu.innerHTML = '';
          menu.style.display = 'none';
          menuOpen = false;
          canvas.width = canvas.width;
        }, false);
      }
    }
  }, false);
};
MJPEGCANVAS.MultiStreamViewer.prototype.__proto__ = EventEmitter.prototype;

/**
 * @author Russell Toris - rctoris@wpi.edu
 */

/**
 * A Viewer can be used to stream a single MJPEG topic into a canvas.
 *
 * Emits the following events:
 *   * 'warning' - emitted if the given topic is unavailable
 *   * 'change' - emitted with the topic name that the canvas was changed to
 *
 * @constructor
 * @param options - possible keys include:
 *   * divID - the ID of the HTML div to place the canvas in
 *   * width - the width of the canvas
 *   * height - the height of the canvas
 *   * host - the hostname of the MJPEG server
 *   * port (optional) - the port to connect to
 *   * quality (optional) - the quality of the stream (from 1-100)
 *   * topic - the topic to stream, like '/wide_stereo/left/image_color'
 *   * overlay (optional) - a canvas to overlay after the image is drawn
 *   * refreshRate (optional) - a refresh rate in Hz
 *   * interval (optional) - an interval time in milliseconds
 */
MJPEGCANVAS.Viewer = function(options) {
  var that = this;
  options = options || {};
  var divID = options.divID;
  this.width = $("#livestream").width();
  this.height = $("#livestream").width()/2;
  this.host = options.host;
  this.port = options.port || 8080;
  this.quality = options.quality;
  this.refreshRate = options.refreshRate || 10;
  this.interval = options.interval || 30;
  this.invert = options.invert || false;

  var topic = options.topic;
  var overlay = options.overlay;

  // create no image initially
  this.image = new Image();

  // used if there was an error loading the stream
  var errorIcon = new MJPEGCANVAS.ErrorIcon();

  // create the canvas to render to
  this.canvas = document.createElement('canvas');
  this.canvas.width = this.width;
  this.canvas.height = this.height;
  document.getElementById(divID).appendChild(this.canvas);
  var context = this.canvas.getContext('2d');

  var drawInterval = Math.max(1 / this.refreshRate * 1000, this.interval);
  /**
   * A function to draw the image onto the canvas.
   */
    
    window.onresize = function(event) {
     that.canvas.width = $("#livestream").width();
     that.canvas.height = $("#livestream").width()/2;
      draw();
   };
    
  function draw() {
    // check if we have a valid image
    that.canvas.width = $("#livestream").width();
    that.canvas.height = $("#livestream").width()/2;
    var x = that.canvas.width / 2;
    var y = that.canvas.height / 2;

    if (that.image.width * that.image.height > 0)
    {
        // silly firefox...
        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
          var aux = that.image.src.split('?killcache=');
          that.image.src = aux[0] + '?killcache=' + Math.random(42);
        }
        context.drawImage(that.image, 0, 0, $("#livestream").width(), $("#livestream").width()/2);
    }
    else
    {
      context.font = '20px Arial';
      context.textAlign = 'center';
      context.fillStyle = 'black';
      context.fillText('Almost there, hold on..', x, y); 
    }
  }

  // grab the initial stream
  this.changeStream(topic);

  // call draw with the given interval or rate
  $.get(_baseUrl + "/api/v1/system/stream", function(data)
  {

    if($("#livestream .load5"))
    {
        $("#livestream .load5").remove();
    } 

    that.canvas.width = $("#livestream").width();
    that.canvas.height = $("#livestream").width()/2;

    var x = that.canvas.width / 2;
    var y = that.canvas.height / 2;
    context.font = '20px Arial';
    context.textAlign = 'center';
    context.fillStyle = 'black';

    if(data.status == true)
    {
      context.fillText('Waiting for stream to connect', x, y); 
      setTimeout(function()
      {
        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)
        {
          drawInterval*=10;
        }

        var interval = setInterval(draw, drawInterval);
      }, 1000);
    }
    else
    {
      context.fillText('No stream, is the machinery running?', x, y);  
    }
  });
};
MJPEGCANVAS.Viewer.prototype.__proto__ = EventEmitter.prototype;

/**
 * Change the stream of this canvas to the given topic.
 *
 * @param topic - the topic to stream, like '/wide_stereo/left/image_color'
 */
MJPEGCANVAS.Viewer.prototype.changeStream = function(topic) {
  this.image = new Image();
  // create the image to hold the stream
  var src = this.host;
   
  this.image.src = src;
  // emit an event for the change
  this.emit('change', topic);

};

/**
 * @author Russell Toris - rctoris@wpi.edu
 */

/**
 * A button renders a button with text to an internal canvas. The width will scale to fit the text.
 *
 * @constructor
 * @param options - possible keys include:
 *   * text - the text to display on the button
 *   * height - the height of the button
 */
MJPEGCANVAS.Button = function(options) {
  options = options || {};
  this.text = options.text;
  this.height = options.height;

  // used to draw the text internally
  this.canvas = document.createElement('canvas');
  this.redraw();
};

/**
 * Redraw the button to the internal canvas.
 */
MJPEGCANVAS.Button.prototype.redraw = function() {
  
};

/**
 * @author Russell Toris - rctoris@wpi.edu
 */

/**
* An ErrorIcon contains a image with an error/warning sign on it. The image data for this object
* is contained internally as a data URI string.
*
* @constructor
*/
MJPEGCANVAS.ErrorIcon = function() {
  // create the image
  this.image = new Image();
  // keep the base64 representation internally
  this.image.src ='';
};


return MJPEGCANVAS;
    
});