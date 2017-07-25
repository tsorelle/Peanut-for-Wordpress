var Quaker;
(function (Quaker) {
    var testFormComponent = (function () {
        function testFormComponent() {
            var _this = this;
            this.userInput = ko.observable('');
            this.message = ko.observable('');
            this.setMessage = function (s) {
                _this.message("Message from main vm: " + s);
            };
        }
        return testFormComponent;
    }());
    Quaker.testFormComponent = testFormComponent;
})(Quaker || (Quaker = {}));
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoidGVzdEZvcm1Db21wb25lbnQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlcyI6WyJ0ZXN0Rm9ybUNvbXBvbmVudC50cyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFHQSxJQUFVLE1BQU0sQ0FTZjtBQVRELFdBQVUsTUFBTTtJQUNaO1FBQUE7WUFBQSxpQkFPQztZQU5HLGNBQVMsR0FBRyxFQUFFLENBQUMsVUFBVSxDQUFDLEVBQUUsQ0FBQyxDQUFDO1lBQzlCLFlBQU8sR0FBRyxFQUFFLENBQUMsVUFBVSxDQUFDLEVBQUUsQ0FBQyxDQUFDO1lBRXJCLGVBQVUsR0FBRyxVQUFDLENBQVM7Z0JBQzFCLEtBQUksQ0FBQyxPQUFPLENBQUMsd0JBQXdCLEdBQUcsQ0FBQyxDQUFDLENBQUM7WUFDL0MsQ0FBQyxDQUFDO1FBQ04sQ0FBQztRQUFELHdCQUFDO0lBQUQsQ0FBQyxBQVBELElBT0M7SUFQWSx3QkFBaUIsb0JBTzdCLENBQUE7QUFDTCxDQUFDLEVBVFMsTUFBTSxLQUFOLE1BQU0sUUFTZiJ9