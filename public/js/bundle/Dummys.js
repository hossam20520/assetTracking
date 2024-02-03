(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["Dummys"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/settings/dummys.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/views/app/pages/settings/dummys.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var nprogress__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! nprogress */ "./node_modules/nprogress/nprogress.js");
/* harmony import */ var nprogress__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(nprogress__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  metaInfo: {
    title: "Dummy"
  },
  data: function data() {
    return {
      isLoading: true,
      SubmitProcessing: false,
      serverParams: {
        columnFilters: {},
        sort: {
          field: "id",
          type: "desc"
        },
        page: 1,
        perPage: 10
      },
      selectedIds: [],
      totalRows: "",
      search: "",
      data: new FormData(),
      editmode: false,
      dummys: [],
      rooms: [],
      floors: [],
      limit: "10",
      locations: [],
      import_products: "",
      category: [],
      dummy: {
        id: "",
        room_id: "",
        location_id: "",
        floor_id: "",
        major_id: 0,
        minor_id: 0,
        detaild_id: 0,
        room_number: "",
        major_category: "",
        minor_category: "",
        detailed_categories: ""
      }
    };
  },
  computed: {
    columns: function columns() {
      return [{
        label: this.$t("room_name"),
        field: "room_name",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("item_name"),
        field: "item_name",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("room_number"),
        field: "room_number",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("floor"),
        field: "floor",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("major_category"),
        field: "major_category",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("minor_category"),
        field: "minor_category",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("detailed_categories"),
        field: "detailed_categories",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("status"),
        field: "status",
        tdClass: "text-left",
        thClass: "text-left"
      }, {
        label: this.$t("Action"),
        field: "actions",
        html: true,
        tdClass: "text-right",
        thClass: "text-right",
        sortable: false
      }];
    }
  },
  methods: {
    //---- update Params Table
    updateParams: function updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },
    //---- Event Page Change
    onPageChange: function onPageChange(_ref) {
      var currentPage = _ref.currentPage;

      if (this.serverParams.page !== currentPage) {
        this.updateParams({
          page: currentPage
        });
        this.Get_Dummys(currentPage);
      }
    },
    //---- Event Per Page Change
    onPerPageChange: function onPerPageChange(_ref2) {
      var currentPerPage = _ref2.currentPerPage;

      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({
          page: 1,
          perPage: currentPerPage
        });
        this.Get_Dummys(1);
      }
    },
    //---- Event on Sort Change
    onSortChange: function onSortChange(params) {
      this.updateParams({
        sort: {
          type: params[0].type,
          field: params[0].field
        }
      });
      this.Get_Dummys(this.serverParams.page);
    },
    //---- Event Select Rows
    selectionChanged: function selectionChanged(_ref3) {
      var _this = this;

      var selectedRows = _ref3.selectedRows;
      this.selectedIds = [];
      selectedRows.forEach(function (row, index) {
        _this.selectedIds.push(row.id);
      });
    },
    //---- Event on Search
    onSearch: function onSearch(value) {
      this.search = value.searchTerm;
      this.Get_Dummys(this.serverParams.page);
    },
    //---- Validation State Form
    getValidationState: function getValidationState(_ref4) {
      var dirty = _ref4.dirty,
          validated = _ref4.validated,
          _ref4$valid = _ref4.valid,
          valid = _ref4$valid === void 0 ? null : _ref4$valid;
      return dirty || validated ? valid : null;
    },
    handleChange_floor: function handleChange_floor(selectedValue) {
      this.getRooms(selectedValue);
    },
    handleChange: function handleChange(selectedValue) {
      this.getLocations(selectedValue);
    },
    onFileSelecteded: function onFileSelecteded(e) {
      this.import_products = "";
      var file = e.target.files[0];
      var errorFilesize;

      if (file["size"] < 1048576) {
        // 1 mega = 1,048,576 Bytes
        errorFilesize = false;
      } else {
        this.makeToast("danger", this.$t("file_size_must_be_less_than_1_mega"), this.$t("Failed"));
      }

      if (errorFilesize === false) {
        this.import_products = file;
      }
    },
    Submit_import: function Submit_import() {
      var _this2 = this;

      // Start the progress bar.
      nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.start();
      nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.set(0.1);
      var self = this;
      self.ImportProcessing = true;
      self.data.append("dummys", self.import_products);
      axios.post("dummys/import/csv", self.data).then(function (response) {
        self.ImportProcessing = false;

        if (response.data.status === true) {
          _this2.makeToast("success", _this2.$t("Successfully_Imported"), _this2.$t("Success"));

          Fire.$emit("Event_import");
        } else if (response.data.status === false) {
          _this2.makeToast("danger", _this2.$t("field_must_be_in_csv_format"), _this2.$t("Failed"));
        } // Complete the animation of theprogress bar.


        nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done();
      })["catch"](function (error) {
        self.ImportProcessing = false; // Complete the animation of theprogress bar.

        nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done(); // this.makeToast(
        //   "danger",
        //   this.$t("Please_follow_the_import_instructions"),
        //   this.$t("Failed")
        // );
      });
    },
    getRooms: function getRooms(selectedValue) {
      var _this3 = this;

      axios.get("dropdown/get/room?type=" + selectedValue).then(function (response) {
        _this3.rooms = response.data.rooms;
      })["catch"](function (response) {
        // Complete the animation of theprogress bar.
        nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done();
        setTimeout(function () {
          _this3.isLoading = false;
        }, 500);
      });
    },
    getLocations: function getLocations(selectedValue) {
      var _this4 = this;

      axios.get("dropdown/get?type=" + selectedValue).then(function (response) {
        _this4.floors = response.data.floors;
      })["catch"](function (response) {
        // Complete the animation of theprogress bar.
        nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done();
        setTimeout(function () {
          _this4.isLoading = false;
        }, 500);
      });
    },
    //------------- Submit Validation Create & Edit Dummy
    Submit_Dummy: function Submit_Dummy() {
      var _this5 = this;

      this.$refs.Create_dummy.validate().then(function (success) {
        if (!success) {
          _this5.makeToast("danger", _this5.$t("Please_fill_the_form_correctly"), _this5.$t("Failed"));
        } else {
          if (!_this5.editmode) {
            _this5.Create_Dummy();
          } else {
            _this5.Update_Dummy();
          }
        }
      });
    },
    //------ Toast
    makeToast: function makeToast(variant, msg, title) {
      this.$root.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true
      });
    },
    //------------------------------ Event Upload Image -------------------------------\
    onFileSelected: function onFileSelected(e) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var _yield$_this6$$refs$I, valid;

        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this6.$refs.Image.validate(e);

              case 2:
                _yield$_this6$$refs$I = _context.sent;
                valid = _yield$_this6$$refs$I.valid;

                if (valid) {
                  _this6.dummy.image = e.target.files[0];
                } else {
                  _this6.dummy.image = "";
                }

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    //------------------------------ Modal (create Dummy) -------------------------------\
    New_Dummy: function New_Dummy() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_dummy");
    },
    New_Insert: function New_Insert() {
      this.reset_Form(); // this.editmode = false;

      this.$bvModal.show("New_dummy_insert");
    },
    //------------------------------ Modal (Update Dummy) -------------------------------\
    Edit_Dummy: function Edit_Dummy(dummy) {
      this.Get_Dummys(this.serverParams.page);
      this.reset_Form();
      this.dummy = dummy;
      this.editmode = true;
      this.$bvModal.show("New_dummy");
    },
    //---------------------------------------- Get All dummys-----------------\
    Get_Dummys: function Get_Dummys(page) {
      var _this7 = this;

      // Start the progress bar.
      nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.start();
      nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.set(0.1);
      axios.get("dummys?page=" + page + "&SortField=" + this.serverParams.sort.field + "&SortType=" + this.serverParams.sort.type + "&search=" + this.search + "&limit=" + this.limit).then(function (response) {
        _this7.dummys = response.data.dummys;
        _this7.totalRows = response.data.totalRows;
        _this7.locations = response.data.locations;
        _this7.category = response.data.category; // this.rooms = response.data.rooms;
        // console.log(response.data.rooms)
        // Complete the animation of theprogress bar.

        nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done();
        _this7.isLoading = false;
      })["catch"](function (response) {
        // Complete the animation of theprogress bar.
        nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done();
        setTimeout(function () {
          _this7.isLoading = false;
        }, 500);
      });
    },
    //---------------------------------------- Create new dummy-----------------\
    Create_Dummy: function Create_Dummy() {
      var _this8 = this;

      var self = this;
      self.SubmitProcessing = true;
      self.data.append("room_name", self.dummy.room_name); // self.data.append("en_name", self.dummy.en_name);
      // self.data.append("image", self.dummy.image);

      axios.post("dummys", self.data).then(function (response) {
        self.SubmitProcessing = false;
        Fire.$emit("Event_Dummy");

        _this8.makeToast("success", _this8.$t("Create.TitleDummy"), _this8.$t("Success"));
      })["catch"](function (error) {
        self.SubmitProcessing = false; // this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
      });
    },
    //---------------------------------------- Update Dummy-----------------\
    Update_Dummy: function Update_Dummy() {
      var _this9 = this;

      var self = this;
      self.SubmitProcessing = true;
      self.data.append("room_name", self.dummy.room_name); // self.data.append("ar_name", self.dummy.ar_name);
      // self.data.append("image", self.dummy.image);

      self.data.append("_method", "put");
      axios.post("dummys/" + self.dummy.id, self.data).then(function (response) {
        self.SubmitProcessing = false;
        Fire.$emit("Event_Dummy");

        _this9.makeToast("success", _this9.$t("Update.TitleDummy"), _this9.$t("Success"));
      })["catch"](function (error) {
        self.SubmitProcessing = false; // this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
      });
    },
    //---------------------------------------- Reset Form -----------------\
    reset_Form: function reset_Form() {
      this.dummy = {
        id: "",
        ar_name: "",
        en_name: "",
        image: ""
      };
      this.data = new FormData();
    },
    //---------------------------------------- Delete Dummy -----------------\
    Delete_Dummy: function Delete_Dummy(id) {
      var _this10 = this;

      this.$swal({
        title: this.$t("Delete.Title"),
        text: this.$t("Delete.Text"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("Delete.cancelButtonText"),
        confirmButtonText: this.$t("Delete.confirmButtonText")
      }).then(function (result) {
        if (result.value) {
          axios["delete"]("dummys/" + id).then(function () {
            _this10.$swal(_this10.$t("Delete.Deleted"), _this10.$t("Delete.TitleDummy"), "success");

            Fire.$emit("Delete_Dummy");
          })["catch"](function () {
            _this10.$swal(_this10.$t("Delete.Failed"), _this10.$t("Delete.Therewassomethingwronge"), "warning");
          });
        }
      });
    },
    Show_import_Dummy: function Show_import_Dummy() {
      this.$bvModal.show("importDummy");
    },
    Insert_by_selected: function Insert_by_selected() {
      this.$bvModal.show("New_dummy");
    },
    add_data_by_selected: function add_data_by_selected() {
      var _this11 = this;

      this.$swal({
        title: this.$t("InsertData"),
        text: this.$t("InsertData"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("cancel"),
        confirmButtonText: this.$t("confirm")
      }).then(function (result) {
        if (result.value) {
          // Start the progress bar.
          nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.start();
          nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.set(0.1);
          axios.post("dummys/insert/by_selection", {
            selectedIds: _this11.selectedIds,
            room_id: _this11.dummy.room_id,
            location_id: _this11.dummy.location_id,
            floor_id: _this11.dummy.floor_id,
            major_id: _this11.dummy.major_id,
            minor_id: _this11.dummy.minor_id,
            detaild_id: _this11.dummy.detaild_id,
            room_number: _this11.dummy.room_number,
            major_category: _this11.dummy.major_category,
            minor_category: _this11.dummy.minor_category,
            detailed_categories: _this11.dummy.detailed_categories
          }).then(function () {
            _this11.$swal(_this11.$t("Success"), _this11.$t("Success"), "success");

            Fire.$emit("Delete_Dummy");
          })["catch"](function () {
            // Complete the animation of theprogress bar.
            setTimeout(function () {
              return nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done();
            }, 500); // this.$swal(
            //   this.$t("Delete.Failed"),
            //   this.$t("Delete.Therewassomethingwronge"),
            //   "warning"
            // );
          });
        }
      });
    },
    //---- Delete dummys by selection
    delete_by_selected: function delete_by_selected() {
      var _this12 = this;

      this.$swal({
        title: this.$t("Delete.Title"),
        text: this.$t("Delete.Text"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("Delete.cancelButtonText"),
        confirmButtonText: this.$t("Delete.confirmButtonText")
      }).then(function (result) {
        if (result.value) {
          // Start the progress bar.
          nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.start();
          nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.set(0.1);
          axios.post("dummys/delete/by_selection", {
            selectedIds: _this12.selectedIds
          }).then(function () {
            _this12.$swal(_this12.$t("Delete.Deleted"), _this12.$t("Delete.TitleDummy"), "success");

            Fire.$emit("Delete_Dummy");
          })["catch"](function () {
            // Complete the animation of theprogress bar.
            setTimeout(function () {
              return nprogress__WEBPACK_IMPORTED_MODULE_0___default.a.done();
            }, 500);

            _this12.$swal(_this12.$t("Delete.Failed"), _this12.$t("Delete.Therewassomethingwronge"), "warning");
          });
        }
      });
    }
  },
  //end Methods
  created: function created() {
    var _this13 = this;

    this.Get_Dummys(1);
    Fire.$on("Event_Dummy", function () {
      setTimeout(function () {
        _this13.Get_Dummys(_this13.serverParams.page);

        _this13.$bvModal.hide("New_dummy");
      }, 500);
    });
    Fire.$on("Delete_Dummy", function () {
      setTimeout(function () {
        _this13.Get_Dummys(_this13.serverParams.page);
      }, 500);
    }); // Fire.$on("Event_import", () => {
    //   setTimeout(() => {
    //     this.Get_Products(this.serverParams.page);
    //     this.$bvModal.hide("importProducts");
    //   }, 500);
    // });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/settings/dummys.vue?vue&type=template&id=37d7006a&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/src/views/app/pages/settings/dummys.vue?vue&type=template&id=37d7006a& ***!
  \************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "main-content" },
    [
      _c("breadcumb", {
        attrs: { page: _vm.$t("Dummy"), folder: _vm.$t("Settings") },
      }),
      _vm._v(" "),
      _vm.isLoading
        ? _c("div", {
            staticClass: "loading_page spinner spinner-primary mr-3",
          })
        : _vm._e(),
      _vm._v(" "),
      !_vm.isLoading
        ? _c(
            "b-card",
            { staticClass: "wrapper" },
            [
              _c(
                "vue-good-table",
                {
                  attrs: {
                    mode: "remote",
                    columns: _vm.columns,
                    totalRows: _vm.totalRows,
                    rows: _vm.dummys,
                    "search-options": {
                      enabled: true,
                      placeholder: _vm.$t("Search_this_table"),
                    },
                    "select-options": {
                      enabled: true,
                      clearSelectionText: "",
                    },
                    "pagination-options": {
                      enabled: true,
                      mode: "records",
                      nextLabel: "next",
                      prevLabel: "prev",
                    },
                    styleClass: "table-hover tableOne vgt-table",
                  },
                  on: {
                    "on-page-change": _vm.onPageChange,
                    "on-per-page-change": _vm.onPerPageChange,
                    "on-sort-change": _vm.onSortChange,
                    "on-search": _vm.onSearch,
                    "on-selected-rows-change": _vm.selectionChanged,
                  },
                  scopedSlots: _vm._u(
                    [
                      {
                        key: "table-row",
                        fn: function (props) {
                          return [
                            props.column.field == "actions"
                              ? _c("span", [
                                  _c(
                                    "a",
                                    {
                                      directives: [
                                        {
                                          name: "b-tooltip",
                                          rawName: "v-b-tooltip.hover",
                                          modifiers: { hover: true },
                                        },
                                      ],
                                      attrs: { title: "Edit" },
                                      on: {
                                        click: function ($event) {
                                          return _vm.Edit_Dummy(props.row)
                                        },
                                      },
                                    },
                                    [
                                      _c("i", {
                                        staticClass:
                                          "i-Edit text-25 text-success",
                                      }),
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "a",
                                    {
                                      directives: [
                                        {
                                          name: "b-tooltip",
                                          rawName: "v-b-tooltip.hover",
                                          modifiers: { hover: true },
                                        },
                                      ],
                                      attrs: { title: "Delete" },
                                      on: {
                                        click: function ($event) {
                                          return _vm.Delete_Dummy(props.row.id)
                                        },
                                      },
                                    },
                                    [
                                      _c("i", {
                                        staticClass:
                                          "i-Close-Window text-25 text-danger",
                                      }),
                                    ]
                                  ),
                                ])
                              : props.column.field == "image"
                              ? _c(
                                  "span",
                                  [
                                    _c("b-img", {
                                      attrs: {
                                        thumbnail: "",
                                        height: "50",
                                        width: "50",
                                        fluid: "",
                                        src:
                                          "/images/dummys/" + props.row.image,
                                        alt: "image",
                                      },
                                    }),
                                  ],
                                  1
                                )
                              : _vm._e(),
                          ]
                        },
                      },
                    ],
                    null,
                    false,
                    357042658
                  ),
                },
                [
                  _c(
                    "div",
                    {
                      attrs: { slot: "selected-row-actions" },
                      slot: "selected-row-actions",
                    },
                    [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary btn-sm",
                          on: {
                            click: function ($event) {
                              return _vm.New_Insert()
                            },
                          },
                        },
                        [_vm._v(" " + _vm._s(_vm.$t("Insert")))]
                      ),
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "mt-2 mb-3",
                      attrs: { slot: "table-actions" },
                      slot: "table-actions",
                    },
                    [
                      _c(
                        "b-button",
                        {
                          staticClass: "btn-rounded",
                          attrs: { variant: "btn btn-primary btn-icon m-1" },
                          on: {
                            click: function ($event) {
                              return _vm.New_Dummy()
                            },
                          },
                        },
                        [
                          _c("i", { staticClass: "i-Add" }),
                          _vm._v(
                            "\n           " +
                              _vm._s(_vm.$t("Add")) +
                              "\n        "
                          ),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "b-button",
                        {
                          attrs: { size: "sm", variant: "info m-1" },
                          on: {
                            click: function ($event) {
                              return _vm.Show_import_Dummy()
                            },
                          },
                        },
                        [
                          _c("i", { staticClass: "i-Download" }),
                          _vm._v(
                            "\n          " +
                              _vm._s(_vm.$t("import_dummy")) +
                              "\n        "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]
              ),
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "validation-observer",
        { ref: "Create_dummy" },
        [
          _c(
            "b-modal",
            {
              attrs: {
                "hide-footer": "",
                size: "md",
                id: "New_dummy",
                title: _vm.editmode ? _vm.$t("Edit") : _vm.$t("Add"),
              },
            },
            [
              _c(
                "b-form",
                {
                  attrs: { enctype: "multipart/form-data" },
                  on: {
                    submit: function ($event) {
                      $event.preventDefault()
                      return _vm.Submit_Dummy($event)
                    },
                  },
                },
                [
                  _c(
                    "b-row",
                    [
                      _c(
                        "b-col",
                        { staticClass: "mb-2", attrs: { md: "12" } },
                        [
                          _c("validation-provider", {
                            attrs: {
                              name: "dummy room",
                              rules: { required: true },
                            },
                            scopedSlots: _vm._u([
                              {
                                key: "default",
                                fn: function (ref) {
                                  var valid = ref.valid
                                  var errors = ref.errors
                                  return _c(
                                    "b-form-group",
                                    { attrs: { label: _vm.$t("room") } },
                                    [
                                      _c("v-select", {
                                        class: {
                                          "is-invalid": !!errors.length,
                                        },
                                        attrs: {
                                          state: errors[0]
                                            ? false
                                            : valid
                                            ? true
                                            : null,
                                          placeholder: _vm.$t("Choose_room"),
                                          reduce: function (label) {
                                            return label.value
                                          },
                                          options: _vm.rooms.map(function (
                                            rooms
                                          ) {
                                            return {
                                              label: rooms.room_name,
                                              value: rooms.id,
                                            }
                                          }),
                                        },
                                        model: {
                                          value: _vm.dummy.room_name,
                                          callback: function ($$v) {
                                            _vm.$set(
                                              _vm.dummy,
                                              "room_name",
                                              $$v
                                            )
                                          },
                                          expression: "dummy.room_name",
                                        },
                                      }),
                                      _vm._v(" "),
                                      _c("b-form-invalid-feedback", [
                                        _vm._v(_vm._s(errors[0])),
                                      ]),
                                    ],
                                    1
                                  )
                                },
                              },
                            ]),
                          }),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-col",
                        { staticClass: "mt-3", attrs: { md: "12" } },
                        [
                          _c(
                            "b-button",
                            {
                              attrs: {
                                variant: "primary",
                                type: "submit",
                                disabled: _vm.SubmitProcessing,
                              },
                            },
                            [_vm._v(" " + _vm._s(_vm.$t("submit")))]
                          ),
                          _vm._v(" "),
                          _vm.SubmitProcessing ? _vm._m(0) : _vm._e(),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                ],
                1
              ),
            ],
            1
          ),
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            "hide-footer": "",
            size: "md",
            id: "New_dummy_insert",
            title: "insertDummy",
          },
        },
        [
          _c(
            "b-form",
            {
              attrs: { enctype: "multipart/form-data" },
              on: {
                submit: function ($event) {
                  $event.preventDefault()
                  return _vm.Submit_Dummy($event)
                },
              },
            },
            [
              _c(
                "b-row",
                [
                  _c(
                    "b-col",
                    { staticClass: "mb-2", attrs: { md: "12" } },
                    [
                      _c("validation-provider", {
                        attrs: {
                          name: "dummy room",
                          rules: { required: true },
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function (ref) {
                              var valid = ref.valid
                              var errors = ref.errors
                              return _c(
                                "b-form-group",
                                { attrs: { label: _vm.$t("locations") } },
                                [
                                  _c("v-select", {
                                    class: { "is-invalid": !!errors.length },
                                    attrs: {
                                      state: errors[0]
                                        ? false
                                        : valid
                                        ? true
                                        : null,
                                      placeholder: _vm.$t("Choose_room"),
                                      reduce: function (label) {
                                        return label.value
                                      },
                                      options: _vm.locations.map(function (
                                        locations
                                      ) {
                                        return {
                                          label: locations.ar_name,
                                          value: locations.id,
                                        }
                                      }),
                                    },
                                    on: { input: _vm.handleChange },
                                    model: {
                                      value: _vm.dummy.location_id,
                                      callback: function ($$v) {
                                        _vm.$set(_vm.dummy, "location_id", $$v)
                                      },
                                      expression: "dummy.location_id",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c("b-form-invalid-feedback", [
                                    _vm._v(_vm._s(errors[0])),
                                  ]),
                                ],
                                1
                              )
                            },
                          },
                        ]),
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-col",
                    { staticClass: "mb-2", attrs: { md: "12" } },
                    [
                      _c("validation-provider", {
                        attrs: { name: "floors", rules: { required: true } },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function (ref) {
                              var valid = ref.valid
                              var errors = ref.errors
                              return _c(
                                "b-form-group",
                                { attrs: { label: _vm.$t("floors") } },
                                [
                                  _c("v-select", {
                                    class: { "is-invalid": !!errors.length },
                                    attrs: {
                                      state: errors[0]
                                        ? false
                                        : valid
                                        ? true
                                        : null,
                                      placeholder: _vm.$t("floors"),
                                      reduce: function (label) {
                                        return label.value
                                      },
                                      options: _vm.floors.map(function (
                                        floors
                                      ) {
                                        return {
                                          label: floors.ar_name,
                                          value: floors.id,
                                        }
                                      }),
                                    },
                                    on: { input: _vm.handleChange_floor },
                                    model: {
                                      value: _vm.dummy.floor_id,
                                      callback: function ($$v) {
                                        _vm.$set(_vm.dummy, "floor_id", $$v)
                                      },
                                      expression: "dummy.floor_id",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c("b-form-invalid-feedback", [
                                    _vm._v(_vm._s(errors[0])),
                                  ]),
                                ],
                                1
                              )
                            },
                          },
                        ]),
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-col",
                    { staticClass: "mb-2", attrs: { md: "12" } },
                    [
                      _c("validation-provider", {
                        attrs: { name: "floors", rules: { required: true } },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function (ref) {
                              var valid = ref.valid
                              var errors = ref.errors
                              return _c(
                                "b-form-group",
                                { attrs: { label: _vm.$t("room") } },
                                [
                                  _c("v-select", {
                                    class: { "is-invalid": !!errors.length },
                                    attrs: {
                                      state: errors[0]
                                        ? false
                                        : valid
                                        ? true
                                        : null,
                                      placeholder: _vm.$t("room"),
                                      reduce: function (label) {
                                        return label.value
                                      },
                                      options: _vm.rooms.map(function (rooms) {
                                        return {
                                          label: rooms.ar_name,
                                          value: rooms.id,
                                        }
                                      }),
                                    },
                                    model: {
                                      value: _vm.dummy.room_id,
                                      callback: function ($$v) {
                                        _vm.$set(_vm.dummy, "room_id", $$v)
                                      },
                                      expression: "dummy.room_id",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c("b-form-invalid-feedback", [
                                    _vm._v(_vm._s(errors[0])),
                                  ]),
                                ],
                                1
                              )
                            },
                          },
                        ]),
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-col",
                    { staticClass: "mb-2", attrs: { md: "12" } },
                    [
                      _c("validation-provider", {
                        attrs: { name: "major_id", rules: { required: true } },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function (ref) {
                              var valid = ref.valid
                              var errors = ref.errors
                              return _c(
                                "b-form-group",
                                { attrs: { label: _vm.$t("major_id") } },
                                [
                                  _c("v-select", {
                                    class: { "is-invalid": !!errors.length },
                                    attrs: {
                                      state: errors[0]
                                        ? false
                                        : valid
                                        ? true
                                        : null,
                                      placeholder: _vm.$t("major_id"),
                                      reduce: function (label) {
                                        return label.value
                                      },
                                      options: _vm.category.map(function (
                                        category
                                      ) {
                                        return {
                                          label: category.name,
                                          value: category.id,
                                        }
                                      }),
                                    },
                                    model: {
                                      value: _vm.dummy.major_id,
                                      callback: function ($$v) {
                                        _vm.$set(_vm.dummy, "major_id", $$v)
                                      },
                                      expression: "dummy.major_id",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c("b-form-invalid-feedback", [
                                    _vm._v(_vm._s(errors[0])),
                                  ]),
                                ],
                                1
                              )
                            },
                          },
                        ]),
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-col",
                    { staticClass: "mb-2", attrs: { md: "12" } },
                    [
                      _c("validation-provider", {
                        attrs: { name: "minor_id", rules: { required: true } },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function (ref) {
                              var valid = ref.valid
                              var errors = ref.errors
                              return _c(
                                "b-form-group",
                                { attrs: { label: _vm.$t("minor_id") } },
                                [
                                  _c("v-select", {
                                    class: { "is-invalid": !!errors.length },
                                    attrs: {
                                      state: errors[0]
                                        ? false
                                        : valid
                                        ? true
                                        : null,
                                      placeholder: _vm.$t("minor_id"),
                                      reduce: function (label) {
                                        return label.value
                                      },
                                      options: _vm.category.map(function (
                                        category
                                      ) {
                                        return {
                                          label: category.name,
                                          value: category.id,
                                        }
                                      }),
                                    },
                                    model: {
                                      value: _vm.dummy.minor_id,
                                      callback: function ($$v) {
                                        _vm.$set(_vm.dummy, "minor_id", $$v)
                                      },
                                      expression: "dummy.minor_id",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c("b-form-invalid-feedback", [
                                    _vm._v(_vm._s(errors[0])),
                                  ]),
                                ],
                                1
                              )
                            },
                          },
                        ]),
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-col",
                    { staticClass: "mb-2", attrs: { md: "12" } },
                    [
                      _c("validation-provider", {
                        attrs: {
                          name: "detaild_id",
                          rules: { required: true },
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function (ref) {
                              var valid = ref.valid
                              var errors = ref.errors
                              return _c(
                                "b-form-group",
                                { attrs: { label: _vm.$t("detaild_id") } },
                                [
                                  _c("v-select", {
                                    class: { "is-invalid": !!errors.length },
                                    attrs: {
                                      state: errors[0]
                                        ? false
                                        : valid
                                        ? true
                                        : null,
                                      placeholder: _vm.$t("detaild_id"),
                                      reduce: function (label) {
                                        return label.value
                                      },
                                      options: _vm.category.map(function (
                                        category
                                      ) {
                                        return {
                                          label: category.name,
                                          value: category.id,
                                        }
                                      }),
                                    },
                                    model: {
                                      value: _vm.dummy.detaild_id,
                                      callback: function ($$v) {
                                        _vm.$set(_vm.dummy, "detaild_id", $$v)
                                      },
                                      expression: "dummy.detaild_id",
                                    },
                                  }),
                                  _vm._v(" "),
                                  _c("b-form-invalid-feedback", [
                                    _vm._v(_vm._s(errors[0])),
                                  ]),
                                ],
                                1
                              )
                            },
                          },
                        ]),
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-col",
                    { staticClass: "mt-3", attrs: { md: "12" } },
                    [
                      _c(
                        "b-button",
                        {
                          attrs: { variant: "primary", type: "submit" },
                          on: { click: _vm.add_data_by_selected },
                        },
                        [_vm._v(" " + _vm._s(_vm.$t("submit")))]
                      ),
                      _vm._v(" "),
                      _vm.SubmitProcessing ? _vm._m(1) : _vm._e(),
                    ],
                    1
                  ),
                ],
                1
              ),
            ],
            1
          ),
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            "ok-only": "",
            "ok-title": "Cancel",
            size: "md",
            id: "importDummy",
            title: _vm.$t("import_dummy"),
          },
        },
        [
          _c(
            "b-form",
            {
              attrs: { enctype: "multipart/form-data" },
              on: {
                submit: function ($event) {
                  $event.preventDefault()
                  return _vm.Submit_import($event)
                },
              },
            },
            [
              _c(
                "b-row",
                [
                  _c(
                    "b-col",
                    { staticClass: "mb-3", attrs: { md: "12", sm: "12" } },
                    [
                      _c(
                        "b-form-group",
                        [
                          _c("input", {
                            attrs: { type: "file", label: "Choose File" },
                            on: { change: _vm.onFileSelecteded },
                          }),
                          _vm._v(" "),
                          _c(
                            "b-form-invalid-feedback",
                            {
                              staticClass: "d-block",
                              attrs: { id: "File-feedback" },
                            },
                            [
                              _vm._v(
                                _vm._s(_vm.$t("field_must_be_in_csv_format"))
                              ),
                            ]
                          ),
                        ],
                        1
                      ),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "b-col",
                    { attrs: { md: "6", sm: "12" } },
                    [
                      _c(
                        "b-button",
                        {
                          attrs: {
                            type: "submit",
                            variant: "primary",
                            disabled: _vm.ImportProcessing,
                            size: "sm",
                            block: "",
                          },
                        },
                        [_vm._v(_vm._s(_vm.$t("submit")))]
                      ),
                      _vm._v(" "),
                      _vm.ImportProcessing ? _vm._m(2) : _vm._e(),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("b-col", { attrs: { md: "12", sm: "12" } }, [
                    _c(
                      "table",
                      { staticClass: "table table-bordered table-sm mt-4" },
                      [
                        _c("tbody", [
                          _c("tr", [
                            _c("td", [_vm._v(_vm._s(_vm.$t("room_name")))]),
                            _vm._v(" "),
                            _c("th", [
                              _c(
                                "span",
                                { staticClass: "badge badge-outline-success" },
                                [_vm._v(_vm._s(_vm.$t("Field_is_required")))]
                              ),
                            ]),
                          ]),
                          _vm._v(" "),
                          _c("tr", [
                            _c("td", [_vm._v(_vm._s(_vm.$t("item_name")))]),
                            _vm._v(" "),
                            _c("th", [
                              _c(
                                "span",
                                { staticClass: "badge badge-outline-success" },
                                [_vm._v(_vm._s(_vm.$t("Field_is_required")))]
                              ),
                              _vm._v(
                                "\n                    " +
                                  _vm._s(_vm.$t("item_name")) +
                                  "\n                  "
                              ),
                            ]),
                          ]),
                          _vm._v(" "),
                          _c("tr", [
                            _c("td", [_vm._v(_vm._s(_vm.$t("room_number")))]),
                            _vm._v(" "),
                            _c("th", [
                              _c(
                                "span",
                                { staticClass: "badge badge-outline-success" },
                                [_vm._v(_vm._s(_vm.$t("Field_is_required")))]
                              ),
                            ]),
                          ]),
                          _vm._v(" "),
                          _c("tr", [
                            _c("td", [_vm._v(_vm._s(_vm.$t("floor")))]),
                            _vm._v(" "),
                            _c("th", [
                              _c(
                                "span",
                                { staticClass: "badge badge-outline-success" },
                                [_vm._v(_vm._s(_vm.$t("Field_is_required")))]
                              ),
                            ]),
                          ]),
                          _vm._v(" "),
                          _c("tr", [
                            _c("td", [_vm._v(_vm._s(_vm.$t("status")))]),
                            _vm._v(" "),
                            _c("th", [
                              _c(
                                "span",
                                { staticClass: "badge badge-outline-success" },
                                [_vm._v(_vm._s(_vm.$t("Field_is_required")))]
                              ),
                            ]),
                          ]),
                        ]),
                      ]
                    ),
                  ]),
                ],
                1
              ),
            ],
            1
          ),
        ],
        1
      ),
    ],
    1
  )
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typo__p" }, [
      _c("div", { staticClass: "spinner sm spinner-primary mt-3" }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typo__p" }, [
      _c("div", { staticClass: "spinner sm spinner-primary mt-3" }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "typo__p" }, [
      _c("div", { staticClass: "spinner sm spinner-primary mt-3" }),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./resources/src/views/app/pages/settings/dummys.vue":
/*!***********************************************************!*\
  !*** ./resources/src/views/app/pages/settings/dummys.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _dummys_vue_vue_type_template_id_37d7006a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dummys.vue?vue&type=template&id=37d7006a& */ "./resources/src/views/app/pages/settings/dummys.vue?vue&type=template&id=37d7006a&");
/* harmony import */ var _dummys_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dummys.vue?vue&type=script&lang=js& */ "./resources/src/views/app/pages/settings/dummys.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _dummys_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _dummys_vue_vue_type_template_id_37d7006a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _dummys_vue_vue_type_template_id_37d7006a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/src/views/app/pages/settings/dummys.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/src/views/app/pages/settings/dummys.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/src/views/app/pages/settings/dummys.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_dummys_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./dummys.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/settings/dummys.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_dummys_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/src/views/app/pages/settings/dummys.vue?vue&type=template&id=37d7006a&":
/*!******************************************************************************************!*\
  !*** ./resources/src/views/app/pages/settings/dummys.vue?vue&type=template&id=37d7006a& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_dummys_vue_vue_type_template_id_37d7006a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./dummys.vue?vue&type=template&id=37d7006a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/src/views/app/pages/settings/dummys.vue?vue&type=template&id=37d7006a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_dummys_vue_vue_type_template_id_37d7006a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_dummys_vue_vue_type_template_id_37d7006a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);