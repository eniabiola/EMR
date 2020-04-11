public class Magic {
	public static void main(String[] args) {  
      int myNumber = 10;
    //myNumber is referred to as Original number
      int stepOne = myNumber * myNumber;		
      int stepTwo = stepOne + myNumber;
      int stepThree = stepTwo/myNumber;
      int stepFour = stepThree + 17;
      int stepFive = stepFour - myNumber;
      int stepSix = stepFive/8;
      System.out.println(stepSix);
	}