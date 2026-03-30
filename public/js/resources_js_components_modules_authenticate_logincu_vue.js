"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_modules_authenticate_logincu_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/logincu.vue?vue&type=script&lang=js"
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/logincu.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// Este archivo vue permite procesar el login mediante
// acceso por clave única, los metodos posteriores son
// los que establecen la conexión con el backend y
// controladores de laravel.
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      listRolePermissionsByUser: [],
      listRolePermissionsByUserFilter: [],
      fullscreenLoading: false,
      error: 0,
      messageError: []
    };
  },
  mounted: function mounted() {
    this.login();
  },
  methods: {
    login: function login() {
      var _this = this;
      this.fullscreenLoading = true;
      var url = '/authenticate/logincu/' + this.$route.params.token;
      this.$axios.get(url).then(function (response) {
        if (response.data.code == 401) {
          _this.loginFailed();
        }
        if (response.data.code == 200) {
          _this.getListRolePermissionsByUser(response.data.authUser);
        }
        _this.fullscreenLoading = false;
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
        _this2.listRolePermissionsByUser = response.data;
        _this2.filterListRolePermissionsByUser(authUser);
      });
    },
    filterListRolePermissionsByUser: function filterListRolePermissionsByUser(authUser) {
      var me = this;
      me.listRolePermissionsByUser.map(function (x, y) {
        me.listRolePermissionsByUserFilter.push(x.slug);
      });
      localStorage.setItem('listRolePermissionsByUser', JSON.stringify(me.listRolePermissionsByUserFilter));
      localStorage.setItem('authUser', JSON.stringify(authUser));
      this.loginSuccess();
    },
    loginFailed: function loginFailed() {
      this.$router.push({
        name: 'login'
      });
    },
    loginSuccess: function loginSuccess() {
      this.$router.push({
        name: 'dashboard.index'
      });
      location.reload();
    }
  }
});

/***/ },

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/logincu.vue?vue&type=template&id=3f8af198"
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/logincu.vue?vue&type=template&id=3f8af198 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div");
}

/***/ },

/***/ "./resources/js/components/modules/authenticate/logincu.vue"
/*!******************************************************************!*\
  !*** ./resources/js/components/modules/authenticate/logincu.vue ***!
  \******************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _logincu_vue_vue_type_template_id_3f8af198__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./logincu.vue?vue&type=template&id=3f8af198 */ "./resources/js/components/modules/authenticate/logincu.vue?vue&type=template&id=3f8af198");
/* harmony import */ var _logincu_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./logincu.vue?vue&type=script&lang=js */ "./resources/js/components/modules/authenticate/logincu.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_logincu_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_logincu_vue_vue_type_template_id_3f8af198__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/modules/authenticate/logincu.vue"]])
/* hot reload */
if (false) // removed by dead control flow
{}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ },

/***/ "./resources/js/components/modules/authenticate/logincu.vue?vue&type=script&lang=js"
/*!******************************************************************************************!*\
  !*** ./resources/js/components/modules/authenticate/logincu.vue?vue&type=script&lang=js ***!
  \******************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_logincu_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_logincu_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./logincu.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/logincu.vue?vue&type=script&lang=js");
 

/***/ },

/***/ "./resources/js/components/modules/authenticate/logincu.vue?vue&type=template&id=3f8af198"
/*!************************************************************************************************!*\
  !*** ./resources/js/components/modules/authenticate/logincu.vue?vue&type=template&id=3f8af198 ***!
  \************************************************************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_logincu_vue_vue_type_template_id_3f8af198__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_logincu_vue_vue_type_template_id_3f8af198__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./logincu.vue?vue&type=template&id=3f8af198 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/modules/authenticate/logincu.vue?vue&type=template&id=3f8af198");


/***/ }

}]);