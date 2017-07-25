var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Quaker;
(function (Quaker) {
    var TestPageViewModel = (function (_super) {
        __extends(TestPageViewModel, _super);
        function TestPageViewModel() {
            var _this = _super !== null && _super.apply(this, arguments) || this;
            _this.messageText = ko.observable('');
            _this.itemName = ko.observable('');
            _this.itemId = ko.observable(1);
            _this.messagePanel = ko.observable('button');
            _this.messageFormVisible = ko.observable(false);
            _this.messageButtonVisible = ko.observable(true);
            _this.save = function () {
                jQuery("#confirm-save-modal").modal('hide');
                alert('you saved');
            };
            _this.onShowError = function () {
                _this.application.showError("This is an error message.");
            };
            _this.onService = function () {
                var me = _this;
                var request = { "tester": 'Terry SoRelle' };
                me.application.hideServiceMessages();
                me.application.showWaiter('Testing service...');
                me.services.executeService('HelloWorld', request, function (serviceResponse) {
                    me.application.hideWaiter();
                    if (serviceResponse.Result == Peanut.serviceResultSuccess) {
                        var response = serviceResponse.Value;
                        alert(response.message);
                    }
                }).fail(function () {
                    me.application.hideWaiter();
                });
            };
            _this.onShowForm = function () {
                console.log('Show form component');
                var me = _this;
                _this.application.attachComponent('tests/test-form', function (returnFuncton) {
                    console.log('accachComponent - returnFunction');
                    _this.application.loadResources('tests/testFormComponent.js', function () {
                        console.log('instatiate testForm component');
                        me.testForm = new Quaker.testFormComponent();
                        me.testForm.setMessage('Watch this space.');
                        me.messagePanel('form');
                        returnFuncton(me.testForm);
                    });
                });
            };
            _this.onSendMessage = function () {
                _this.testForm.setMessage(_this.messageText());
            };
            _this.onShowMessageComponent = function () {
                _this.attachComponent('tests/test-message');
                _this.messageButtonVisible(false);
            };
            return _this;
        }
        TestPageViewModel.prototype.init = function (successFunction) {
            var me = this;
            me.application.registerComponents('tests/intro-message,@pnut/modal-confirm', function () {
                me.application.loadComponents('tests/message-constructor', function () {
                    me.application.loadResources([
                        'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js',
                        '/application/assets/js/libraries/TestLib.js'
                    ], function () {
                        var test = _.head(['one', 'two', 'three']);
                        if (test === 'one') {
                            console.log('Lodash installed');
                        }
                        Testing.Test.sayHello();
                        var cvm = new Quaker.messageConstructorComponent('Smoke Test Buttons:');
                        me.application.registerComponent('tests/message-constructor', cvm, function () {
                            me.bindDefaultSection();
                            successFunction();
                        });
                    });
                });
            });
        };
        TestPageViewModel.prototype.onGetItem = function () {
            var me = this;
            me.application.showWaiter('Please wait...');
            me.services.getFromService('TestGetService', 3, function (serviceResponse) {
                if (serviceResponse.Result == Peanut.serviceResultSuccess) {
                    me.itemName(serviceResponse.Value.name);
                    me.itemId(serviceResponse.Value.id);
                }
                else {
                    alert("Service failed");
                }
            }).always(function () {
                me.application.hideWaiter();
            });
        };
        TestPageViewModel.prototype.onPostItem = function () {
            var me = this;
            var request = {
                testMessageText: me.itemName()
            };
            me.application.showWaiter('Please wait...');
            me.services.executeService('TestService', request)
                .always(function () {
                me.application.hideWaiter();
            });
        };
        TestPageViewModel.prototype.onAddMessageClick = function () {
            var me = this;
            var msg = me.messageText();
            me.application.showMessage(msg);
            me.messageText('');
        };
        TestPageViewModel.prototype.onAddErrorMessageClick = function () {
            var me = this;
            var msg = me.messageText();
            me.application.showError(msg);
            me.messageText('');
        };
        TestPageViewModel.prototype.onAddWarningMessageClick = function () {
            var me = this;
            var msg = me.messageText();
            me.application.showWarning(msg);
            me.messageText('');
        };
        TestPageViewModel.prototype.onShowSpinWaiter = function () {
            var count = 0;
            Peanut.WaitMessage.show("Hello " + (new Date()).toISOString());
            var t = window.setInterval(function () {
                if (count > 100) {
                    clearInterval(t);
                    Peanut.WaitMessage.hide();
                }
                else {
                    Peanut.WaitMessage.setMessage('Counting ' + count);
                }
                count += 1;
            }, 100);
        };
        TestPageViewModel.prototype.onShowWaiter = function () {
            var me = this;
            me.application.showWaiter();
            var t = window.setInterval(function () {
                clearInterval(t);
                me.application.hideWaiter();
            }, 1000);
        };
        TestPageViewModel.prototype.onShowProgressWaiter = function () {
            var count = 0;
            Peanut.WaitMessage.show("Hello " + (new Date()).toISOString(), 'progress-waiter');
            var t = window.setInterval(function () {
                if (count > 100) {
                    clearInterval(t);
                    Peanut.WaitMessage.hide();
                }
                else {
                    Peanut.WaitMessage.setMessage('Counting ' + count);
                    Peanut.WaitMessage.setProgress(count, true);
                }
                count += 1;
            }, 100);
        };
        TestPageViewModel.prototype.onHideWaiter = function () {
            Peanut.WaitMessage.hide();
        };
        TestPageViewModel.prototype.onShowModalForm = function () {
            jQuery("#test-modal").modal('show');
        };
        TestPageViewModel.prototype.onSaveChanges = function () {
            jQuery("#test-modal").modal('hide');
            jQuery("#confirm-save-modal").modal('show');
        };
        return TestPageViewModel;
    }(Peanut.ViewModelBase));
    Quaker.TestPageViewModel = TestPageViewModel;
})(Quaker || (Quaker = {}));
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiVGVzdFBhZ2VWaWV3TW9kZWwuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlcyI6WyJUZXN0UGFnZVZpZXdNb2RlbC50cyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7O0FBZ0JBLElBQVUsTUFBTSxDQTZPZjtBQTdPRCxXQUFVLE1BQU07SUFFWjtRQUF3QyxxQ0FBb0I7UUFBNUQ7WUFBQSxxRUF3T0M7WUF2T0csaUJBQVcsR0FBRyxFQUFFLENBQUMsVUFBVSxDQUFDLEVBQUUsQ0FBQyxDQUFDO1lBRWhDLGNBQVEsR0FBRyxFQUFFLENBQUMsVUFBVSxDQUFDLEVBQUUsQ0FBQyxDQUFDO1lBQzdCLFlBQU0sR0FBRyxFQUFFLENBQUMsVUFBVSxDQUFDLENBQUMsQ0FBQyxDQUFDO1lBQzFCLGtCQUFZLEdBQUcsRUFBRSxDQUFDLFVBQVUsQ0FBQyxRQUFRLENBQUMsQ0FBQztZQUN2Qyx3QkFBa0IsR0FBRyxFQUFFLENBQUMsVUFBVSxDQUFDLEtBQUssQ0FBQyxDQUFDO1lBQzFDLDBCQUFvQixHQUFHLEVBQUUsQ0FBQyxVQUFVLENBQUMsSUFBSSxDQUFDLENBQUM7WUErSjNDLFVBQUksR0FBRztnQkFDSCxNQUFNLENBQUMscUJBQXFCLENBQUMsQ0FBQyxLQUFLLENBQUMsTUFBTSxDQUFDLENBQUM7Z0JBQzVDLEtBQUssQ0FBQyxXQUFXLENBQUMsQ0FBQztZQUN2QixDQUFDLENBQUM7WUFDRixpQkFBVyxHQUFHO2dCQUNWLEtBQUksQ0FBQyxXQUFXLENBQUMsU0FBUyxDQUFDLDJCQUEyQixDQUFDLENBQUM7WUFDNUQsQ0FBQyxDQUFDO1lBQ0YsZUFBUyxHQUFHO2dCQUNSLElBQUksRUFBRSxHQUFHLEtBQUksQ0FBQztnQkFDZCxJQUFJLE9BQU8sR0FBRyxFQUFDLFFBQVEsRUFBRyxlQUFlLEVBQUMsQ0FBQztnQkFDM0MsRUFBRSxDQUFDLFdBQVcsQ0FBQyxtQkFBbUIsRUFBRSxDQUFDO2dCQUNyQyxFQUFFLENBQUMsV0FBVyxDQUFDLFVBQVUsQ0FBQyxv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