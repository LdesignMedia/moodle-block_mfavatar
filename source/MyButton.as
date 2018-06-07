package  {
	
	import flash.display.SimpleButton;

	public class MyButton extends SimpleButton {

		public function MyButton() {
			// constructor code
		}
		
		public function enable(b:Boolean = true):void {
			if (b) {
				this.enabled = true;
				this.alpha = 1;
			} else {
				this.enabled = false;
				this.alpha = 0.33;
			}
		}

	}
	
}
