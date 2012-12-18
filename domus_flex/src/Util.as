package
{
		
	
	public class Util
	{
		public function Util()
		{
		}
				
		
		public function AddPopUp(x,y):void{
			
			import mx.managers.PopUpManager;
			var panel : Dialog = PopUpManager.createPopUp(this, Dialog, false) as Dialog;
			
			if(x == 0 || y == 0){
				PopUpManager.centerPopUp(panel);	
			}
			else
			{
				panel.move(x,y);
			}			
			
		
		}
          

	}
}