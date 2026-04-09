"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_modules_authenticate_login_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/login.vue?vue&type=script&lang=js"
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/login.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      fillLogin: {
        email: '',
        pass: ''
      },
      listRolePermissionsByUser: [],
      listRolePermissionsByUserFilter: [],
      fullscreenLoading: false,
      error: 0,
      messageError: []
    };
  },
  methods: {
    login: function login() {
      var _this = this;
      if (this.validateLogin()) {
        return;
      }
      this.fullscreenLoading = true;
      var url = '/authenticate/login';
      this.$axios.post(url, {
        'email': this.fillLogin.email,
        'pass': this.fillLogin.pass
      }).then(function (response) {
        console.log('Login POST response:', response.data.code); // ← agregar
        if (response.data.code == 401) {
          _this.loginFailed();
        }
        if (response.data.code == 200) {
          console.log('Llamando getListRolePermissions...'); // ← agregar
          _this.getListRolePermissionsByUser(response.data.authUser);
        }
        _this.fullscreenLoading = false;
        console.log('Login response completa:', response.data);
      })["catch"](function (e) {
        console.log('Login POST error:', e.message); // ← agregar
      });
    },
    getListRolePermissionsByUser: function getListRolePermissionsByUser(authUser) {
      var _this2 = this;
      var route = '/administracion/user/getListRolePermissionsByUser';
      this.$axios.get(route, {
        params: {
          'idUser': authUser.id
        }
      }).then(function (response) {
        console.log('response.data:', response.data);
        _this2.listRolePermissionsByUser = response.data;
        if (Array.isArray(response.data)) {
          _this2.listRolePermissionsByUser = response.data;
        } else if (response.data.data && Array.isArray(response.data.data)) {
          _this2.listRolePermissionsByUser = response.data.data; // paginado
        } else {
          _this2.listRolePermissionsByUser = Object.values(response.data); // objeto
        }

        _this2.filterListRolePermissionsByUser(authUser);
      })["catch"](function (error) {
        var _error$response, _error$response2;
        console.log('ERROR status:', (_error$response = error.response) === null || _error$response === void 0 ? void 0 : _error$response.status);
        console.log('ERROR data:', (_error$response2 = error.response) === null || _error$response2 === void 0 ? void 0 : _error$response2.data);
        console.log('ERROR message:', error.message);
      });
    },
    filterListRolePermissionsByUser: function filterListRolePermissionsByUser(authUser) {
      var me = this;
      console.log('primer item permisos:', me.listRolePermissionsByUser[0]); // ← agregar
      me.listRolePermissionsByUser.map(function (x, y) {
        me.listRolePermissionsByUserFilter.push(x.slug);
      });
      var plainArray = Array.from(me.listRolePermissionsByUserFilter);
      console.log('slugs a guardar:', plainArray); // ← agregar
      localStorage.setItem('listRolePermissionsByUser', JSON.stringify(plainArray));
      localStorage.setItem('authUser', JSON.stringify(authUser));
      this.loginSuccess();
    },
    validateLogin: function validateLogin() {
      this.error = 0;
      this.messageError = [];
      if (!this.fillLogin.email) {
        this.messageError.push("Email es un campo obligatorio");
      }
      if (!this.fillLogin.pass) {
        this.messageError.push("Password es un campo obligatorio");
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
    loginFailed: function loginFailed() {
      this.error = 0;
      this.messageError = [];
      this.messageError.push("Esta cuenta no coincide con nuestros registros.");
      this.fillLogin.pass = '';
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
    loginSuccess: function loginSuccess() {
      this.$router.push({
        name: 'dashboard.index'
      });
      // location.reload();
    }
  }
});

/***/ },

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/login.vue?vue&type=template&id=00f04642"
/*!************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/login.vue?vue&type=template&id=00f04642 ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }

var _hoisted_1 = {
  "class": "login-box"
};
var _hoisted_2 = {
  "class": "login-logo"
};
var _hoisted_3 = {
  "class": "card"
};
var _hoisted_4 = {
  "class": "card-body login-card-body"
};
var _hoisted_5 = {
  method: "post"
};
var _hoisted_6 = {
  "class": "input-group mb-3"
};
var _hoisted_7 = {
  "class": "input-group mb-3"
};
var _hoisted_8 = {
  "class": "row"
};
var _hoisted_9 = {
  "class": "col-md-12"
};
var _hoisted_10 = {
  "class": "social-auth-links text-center mb-3"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: {
      name: 'login'
    }
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return _toConsumableArray(_cache[5] || (_cache[5] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", {
        "class": "text-default"
      }, "SIRE", -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("MX ", -1 /* CACHED */)]));
    }, undefined, true),
    _: 1 /* STABLE */
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" /.login-logo "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [_cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<h6 class=\"mb-3 text-center\">Utilizando tu Clave Única</h6><a class=\"btn-cu btn-m btn-color-estandar m-auto\" href=\"https://uni.saludtarapaca.gob.cl/claveunica/siremx\" title=\"Este es el botón Iniciar sesión de ClaveÚnica\"><span class=\"cl-claveunica\"></span><span class=\"texto\">Iniciar sesión</span></a><hr><h6 class=\"login-box-msg\">O con tu cuenta del sistema</h6>", 4)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "email",
    onKeyup: _cache[0] || (_cache[0] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function () {
      return $options.login && $options.login.apply($options, arguments);
    }, ["enter"])),
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.fillLogin.email = $event;
    }),
    "class": "form-control",
    placeholder: "Usuario"
  }, null, 544 /* NEED_HYDRATION, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.fillLogin.email]]), _cache[6] || (_cache[6] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "input-group-append"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "input-group-text"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "fas fa-user"
  })])], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "password",
    onKeyup: _cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withKeys)(function () {
      return $options.login && $options.login.apply($options, arguments);
    }, ["enter"])),
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $data.fillLogin.pass = $event;
    }),
    "class": "form-control",
    placeholder: "Password"
  }, null, 544 /* NEED_HYDRATION, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.fillLogin.pass]]), _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "input-group-append"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "input-group-text"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "fas fa-lock"
  })])], -1 /* CACHED */))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [$data.error ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 0
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.messageError, function (e, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      key: index,
      "class": "callout callout-danger"
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(e), 1 /* TEXT */);
  }), 128 /* KEYED_FRAGMENT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Temporal remove: v-loading.fullscreen.lock=\"fullscreenLoading\" "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-block btn-info",
    onClick: _cache[4] || (_cache[4] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {
      return $options.login && $options.login.apply($options, arguments);
    }, ["prevent"]))
  }, _toConsumableArray(_cache[8] || (_cache[8] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
    "class": "fas fa-sign-in-alt mr-2"
  }, null, -1 /* CACHED */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Iniciar Sesión ", -1 /* CACHED */)])))]), _cache[10] || (_cache[10] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("hr", null, null, -1 /* CACHED */)), _cache[11] || (_cache[11] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    "class": "btn-cu btn-m btn-color-estandar m-auto bg-secondary",
    href: "/claveunica?redirect=L3NpcmVteC9sb2dpbmN1",
    title: "Este es el botón Iniciar sesión de ClaveÚnica"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "cl-claveunica"
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "texto"
  }, "Iniciar sesión")], -1 /* CACHED */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" /.login-card-body ")])]);
}

/***/ },

/***/ "./resources/js/components/modules/authenticate/login.vue"
/*!****************************************************************!*\
  !*** ./resources/js/components/modules/authenticate/login.vue ***!
  \****************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _login_vue_vue_type_template_id_00f04642__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./login.vue?vue&type=template&id=00f04642 */ "./resources/js/components/modules/authenticate/login.vue?vue&type=template&id=00f04642");
/* harmony import */ var _login_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./login.vue?vue&type=script&lang=js */ "./resources/js/components/modules/authenticate/login.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_login_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_login_vue_vue_type_template_id_00f04642__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/modules/authenticate/login.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ },

/***/ "./resources/js/components/modules/authenticate/login.vue?vue&type=script&lang=js"
/*!****************************************************************************************!*\
  !*** ./resources/js/components/modules/authenticate/login.vue?vue&type=script&lang=js ***!
  \****************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_login_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_login_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./login.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/login.vue?vue&type=script&lang=js");
 

/***/ },

/***/ "./resources/js/components/modules/authenticate/login.vue?vue&type=template&id=00f04642"
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/modules/authenticate/login.vue?vue&type=template&id=00f04642 ***!
  \**********************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_login_vue_vue_type_template_id_00f04642__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_login_vue_vue_type_template_id_00f04642__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./login.vue?vue&type=template&id=00f04642 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/login.vue?vue&type=template&id=00f04642");


/***/ }

}]);